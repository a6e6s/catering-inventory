<?php

namespace App\Notifications;

use App\Models\Warehouse;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Filament\Notifications\Notification as FilamentNotification;

class CapacityWarningNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Warehouse $warehouse)
    {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return FilamentNotification::make()
            ->title(__('warehouse.notifications.capacity_warning_title'))
            ->body(__('warehouse.notifications.capacity_warning_body', [
                'name' => $this->warehouse->name,
                'percentage' => $this->warehouse->capacity_percentage
            ]))
            ->warning()
            ->actions([
                \Filament\Notifications\Actions\Action::make('view')
                    ->button()
                    ->url(fn() => \App\Filament\Resources\Warehouses\WarehouseResource::getUrl('view', ['record' => $this->warehouse])),
            ])
            ->getDatabaseMessage();
    }
}
