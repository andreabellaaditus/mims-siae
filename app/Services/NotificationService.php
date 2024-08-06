<?php

namespace App\Services;
use Filament\Notifications\Notification;
use Carbon\Carbon;
use App\Models\Scopes\ActiveScope;

class NotificationService
{

    public function getNotification($result){

        Notification::make()
        ->title($result['title'])
        ->body($result['body'])
        ->color($result['color'])
        ->icon($result['icon'])
        ->iconColor($result['color'])
        ->seconds(5)
        ->send();

    }


}
