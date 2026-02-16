<?php

namespace Database\Factories;

use App\Enums\TransactionApprovalRole;
use App\Enums\TransactionApprovalStatus;
use App\Models\InventoryTransaction;
use App\Models\TransactionApproval;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransactionApproval>
 */
class TransactionApprovalFactory extends Factory
{
    protected $model = TransactionApproval::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transaction_id' => InventoryTransaction::factory(),
            'approver_role' => $this->faker->randomElement(TransactionApprovalRole::cases()),
            'approver_id' => User::factory(),
            'step' => 1,
            'status' => TransactionApprovalStatus::Pending,
            'comments' => null,
            'approved_at' => null,
        ];
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => TransactionApprovalStatus::Approved,
            'approved_at' => now(),
            'comments' => $this->faker->sentence(),
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => TransactionApprovalStatus::Rejected,
            'approved_at' => now(),
            'comments' => $this->faker->sentence(),
        ]);
    }

    public function receiver(): static
    {
        return $this->state(fn (array $attributes) => [
            'approver_role' => TransactionApprovalRole::Receiver,
        ]);
    }

    public function manager(): static
    {
        return $this->state(fn (array $attributes) => [
            'approver_role' => TransactionApprovalRole::WarehouseManager,
        ]);
    }

    public function compliance(): static
    {
        return $this->state(fn (array $attributes) => [
            'approver_role' => TransactionApprovalRole::ComplianceOfficer,
        ]);
    }
}
