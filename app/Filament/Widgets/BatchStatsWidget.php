<?php

namespace App\Filament\Widgets;

use App\Enums\BatchStatus;
use App\Models\Batch;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BatchStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('batch.widgets.expiring_soon'), Batch::expiringSoon(7)->count())
                ->description(__('batch.widgets.expiring_soon_desc'))
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
            
            Stat::make(__('batch.widgets.already_expired'), Batch::where('status', BatchStatus::Expired)->count())
                ->description(__('batch.widgets.already_expired_desc'))
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),

            Stat::make(__('batch.widgets.low_quantity'), Batch::where('quantity', '<', 50)->active()->count())
                ->description(__('batch.widgets.low_quantity_desc'))
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('warning'),
        ];
    }
}
