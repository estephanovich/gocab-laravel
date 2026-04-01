<?php

namespace Modules\CabBooking\Listeners;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Modules\CabBooking\Events\SOSAlertEvent;
use Modules\CabBooking\Notifications\SOSAlertNotification;

class SOSAlertListener
{
    public function handle(SOSAlertEvent $event): void
    {
        $user = User::find($event->ride->user_id);
        if ($user) {
            sendNotifyMail($user, new SOSAlertNotification($event->ride, $event->sos));
        }

        $admins = User::whereHas('roles', fn($q) => $q->where('name', 'admin'))->get();
        foreach ($admins as $admin) {
            sendNotifyMail($admin, new SOSAlertNotification($event->ride, $event->sos));
        }
    }
}
