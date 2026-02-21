<?php

namespace App\Observers;

use App\Enums\InventoryTransactionStatus;
use App\Enums\InventoryTransactionType;
use App\Models\Batch;
use App\Models\InventoryTransaction;
use App\Models\ProductStock;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProductStockObserver
{
    public function creating(ProductStock $productStock): void
    {
        $this->validateQuantity($productStock);
    }

    public function created(ProductStock $productStock): void
    {
        $this->createProductionTransaction($productStock);
        $this->deductRawMaterials($productStock);
    }

    public function updating(ProductStock $productStock): void
    {
        if ($productStock->isDirty('quantity')) {
            $this->validateQuantity($productStock);
        }
    }

    protected function validateQuantity(ProductStock $productStock): void
    {
        if (!$productStock->product_id || !$productStock->quantity) {
            return;
        }

        $product = $productStock->product;
        if (!$product) {
            return;
        }

        $maxQty = $product->calculateMaxProducibleQuantity($productStock->warehouse_id);

        if ($productStock->quantity > $maxQty) {
            throw ValidationException::withMessages([
                'quantity' => __('product_stock.validation.exceeds_available_ingredients', [
                    'max' => $maxQty,
                ]),
            ]);
        }
    }

    protected function createProductionTransaction(ProductStock $productStock): void
    {
        InventoryTransaction::create([
            'type' => InventoryTransactionType::Production,
            'to_warehouse_id' => $productStock->warehouse_id,
            'product_id' => $productStock->product_id,
            'quantity' => $productStock->quantity,
            'status' => InventoryTransactionStatus::Completed,
            'initiated_by' => auth()->id(),
            'completed_by' => auth()->id(),
            'completed_at' => now(),
            'notes' => 'Production: ' . $productStock->product->name,
        ]);
    }

    protected function deductRawMaterials(ProductStock $productStock): void
    {
        $product = $productStock->product;
        $ingredients = $product->ingredients;

        foreach ($ingredients as $ingredient) {
            $requiredQty = $ingredient->quantity_required * $productStock->quantity;
            
            // Deduct from batches (FIFO - oldest first)
            $batches = Batch::where('raw_material_id', $ingredient->raw_material_id)
                ->where('warehouse_id', $productStock->warehouse_id)
                ->where('status', 'active')
                ->where(function($query) {
                    $query->whereNull('expiry_date')
                          ->orWhere('expiry_date', '>', now());
                })
                ->orderBy('received_date', 'asc')
                ->get();

            $remaining = $requiredQty;

            foreach ($batches as $batch) {
                if ($remaining <= 0) {
                    break;
                }

                $deductQty = min($remaining, $batch->quantity);
                $batch->decrement('quantity', $deductQty);
                $remaining -= $deductQty;
            }
        }
    }
}
