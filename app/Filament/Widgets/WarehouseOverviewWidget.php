<?php

namespace App\Filament\Widgets;

use App\Models\Warehouse;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class WarehouseOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $total = Warehouse::count();
        $active = Warehouse::where('is_active', true)->count();
        $inactive = $total - $active;

        // Calculate average utilization
        // This is a bit heavy, in production we might cache this or use a raw query
        $warehouses = Warehouse::whereNotNull('capacity')->get();
        $totalCapacity = $warehouses->sum('capacity');

        // Approximation of total stock (using ProductStock as source of truth)
        $totalStock = \App\Models\ProductStock::sum('quantity');

        $utilization = $totalCapacity > 0 ? round(($totalStock / $totalCapacity) * 100, 1) : 0;

        return [
            Stat::make(__('warehouse.widgets.total_warehouses'), $total)
                ->description(__('warehouse.widgets.total_warehouses_desc'))
                ->descriptionIcon('heroicon-m-building-office')
                ->color('primary'),

            Stat::make(__('warehouse.widgets.active_status'), __('warehouse.widgets.active_status_desc', ['active' => $active, 'inactive' => $inactive]))
                ->description(__('warehouse.widgets.operational_capability')) // Added this key to lang file if missing, or use existing generic
                ->descriptionIcon('heroicon-m-check-circle')
                ->color($inactive > 0 ? 'warning' : 'success'),

            Stat::make(__('warehouse.widgets.capacity_utilization'), "$utilization%")
                ->description(__('warehouse.widgets.capacity_utilization_desc'))
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color($utilization > 80 ? 'danger' : ($utilization > 50 ? 'warning' : 'success')),
        ];
    }
}
