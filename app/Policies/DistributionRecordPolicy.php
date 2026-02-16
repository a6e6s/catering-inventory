<?php

namespace App\Policies;

use App\Enums\DistributionRecordStatus;
use App\Models\DistributionRecord;
use App\Models\User;

class DistributionRecordPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_any_distribution_record');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DistributionRecord $distributionRecord): bool
    {
        return $user->hasPermissionTo('view_distribution_record');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_distribution_record');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DistributionRecord $distributionRecord): bool
    {
        // Can only edit if pending
        if ($distributionRecord->status !== DistributionRecordStatus::Pending) {
             return false;
        }
        return $user->hasPermissionTo('update_distribution_record');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DistributionRecord $distributionRecord): bool
    {
        return $user->hasPermissionTo('delete_distribution_record');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, DistributionRecord $distributionRecord): bool
    {
        return $user->hasPermissionTo('restore_distribution_record');
    }

    /**
     * Determine whether the user can force delete the model.
     */
    public function forceDelete(User $user, DistributionRecord $distributionRecord): bool
    {
        return $user->hasPermissionTo('force_delete_distribution_record');
    }

    /**
     * Determine whether the user can verify the model.
     */
    public function verify(User $user, DistributionRecord $distributionRecord): bool
    {
         if ($distributionRecord->status !== DistributionRecordStatus::Pending) {
             return false;
        }
        return $user->hasPermissionTo('verify_distribution_record');
    }

    /**
     * Determine whether the user can reject the model.
     */
    public function reject(User $user, DistributionRecord $distributionRecord): bool
    {
        if ($distributionRecord->status !== DistributionRecordStatus::Pending) {
             return false;
        }
        return $user->hasPermissionTo('reject_distribution_record');
    }
}
