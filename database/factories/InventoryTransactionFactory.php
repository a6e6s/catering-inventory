<?php

namespace Database\Factories;

use App\Enums\InventoryTransactionStatus;
use App\Enums\InventoryTransactionType;
use App\Models\Batch;
use App\Models\Product;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(InventoryTransactionType::cases()),
            'from_warehouse_id' => Warehouse::factory(),
            'to_warehouse_id' => Warehouse::factory(),
            'product_id' => Product::factory(),
            'batch_id' => Batch::factory(),
            'quantity' => fake()->randomFloat(2, 1, 500),
            'status' => InventoryTransactionStatus::Draft,
            'initiated_by' => User::factory(),
            'notes' => fake()->optional()->sentence(),
            'transaction_date' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }

    /**
     * Transfer between two warehouses.
     */
    public function transfer(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => InventoryTransactionType::Transfer,
        ]);
    }

    /**
     * Return from association to main warehouse.
     */
    public function return(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => InventoryTransactionType::Return,
        ]);
    }

    /**
     * Waste / disposal transaction.
     */
    public function waste(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => InventoryTransactionType::Waste,
            'to_warehouse_id' => null,
        ]);
    }

    /**
     * Distribution transaction.
     */
    public function distribution(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => InventoryTransactionType::Distribution,
            'to_warehouse_id' => null,
        ]);
    }

    /**
     * Manual adjustment.
     */
    public function adjustment(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => InventoryTransactionType::Adjustment,
            'to_warehouse_id' => null,
        ]);
    }

    /**
     * Pending approval status.
     */
    public function pendingApproval(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => InventoryTransactionStatus::PendingApproval,
        ]);
    }

    /**
     * Approved status, ready for completion.
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => InventoryTransactionStatus::Approved,
        ]);
    }

    /**
     * Completed transaction.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => InventoryTransactionStatus::Completed,
            'completed_at' => now(),
            'completed_by' => User::factory(),
        ]);
    }
}
