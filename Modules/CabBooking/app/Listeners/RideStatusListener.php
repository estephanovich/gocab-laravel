<?php

namespace Modules\CabBooking\Listeners;

use Exception;
use App\Models\User;
use App\Enums\RoleEnum;
use Modules\CabBooking\Models\Rider;
use Modules\CabBooking\Models\Driver;
use Illuminate\Support\Facades\Log;
use Modules\CabBooking\Events\RideStatusEvent;
use Modules\CabBooking\Enums\RoleEnum as EnumsRoleEnum;
use Modules\CabBooking\Notifications\RideStatusNotification;

class RideStatusListener
{
    /**
     * Handle the event.
     */
    public function handle(RideStatusEvent $event): void
    {
        try {

            $admins = User::role(RoleEnum::ADMIN)?->whereNull('deleted_at')->get();
            if ($event->ride->driver) {
                $driver_id = $event->ride?->driver_id;
                $driver = Driver::where('id', $driver_id)?->whereNull('deleted_at')?->first();
                $this->sendPushNotification("user_".$driver_id, EnumsRoleEnum::DRIVER, $event->ride);
            }

            if ($event->ride?->rider_id) {
                $rider_id = $event->ride?->rider_id;
                $rider = Rider::where('id', $rider_id)?->whereNull('deleted_at')?->first();
                $this->sendPushNotification("user_".$rider_id, EnumsRoleEnum::RIDER, $event->ride);
            }

        } catch (Exception $e) {

            Log::error('Ride Status Log Handler ' . $e->getMessage());
        }
    }

    private function getNotificationMessage($role, $ride)
    {

        $rideNumber = $ride->ride_number;
        $status = strtoupper($ride?->ride_status?->slug);

        Log::error('==============================');

        Log::error('Ride Status: ' . $status);

        Log::error('Ride Status SLUG: ' . $ride?->ride_status?->slug);

        Log::error('Ride ROLE: ' . $role);

        Log::error('==============================');
        switch ($role) {
            case EnumsRoleEnum::DRIVER:
                switch ($status) {
                    case 'PENDING':
                        return ['title' => "🚨 New Ride Alert!", 'body' => "Ride #$rideNumber is waiting for you! 🚖 Check it out! 🏁"];
                    case 'REQUESTED':
                        return ['title' => "🔔 New Ride Request!", 'body' => "Ride #$rideNumber is up for grabs! 🚗 Ready to roll? 🚀"];
                    case 'SCHEDULED':
                        return ['title' => "📅 Ride Locked In!", 'body' => "Gear up for Ride #$rideNumber! 🛣️ Let's hit the road! 🌟"];
                    case 'ACCEPTED':
                        return ['title' => "🎉 You're On!", 'body' => "Ride #$rideNumber is yours! 🚙 Time to shine! 💨"];
                    case 'REJECTED':
                        return ['title' => "🚫 Ride Passed", 'body' => "Ride #$rideNumber was rejected. More rides await! 😎🚖"];
                    case 'ARRIVED':
                        return ['title' => "🏠 You've Arrived!", 'body' => "Ready for pickup on Ride #$rideNumber! 🎈 Let's go! 🚗"];
                    case 'STARTED':
                        return ['title' => "🚀 Ride's On!", 'body' => "Ride #$rideNumber is rolling! Safe travels! 🌟🚙"];
                    case 'CANCELLED':
                        return ['title' => "😕 Ride Cancelled", 'body' => "Ride #$rideNumber was cancelled. Next one’s coming! 🚖"];
                    case 'COMPLETED':
                        return ['title' => "🥳 Ride Done!", 'body' => "Awesome job on Ride #$rideNumber! 🎉 Keep rocking it! 😊"];
                }
                break;

            case EnumsRoleEnum::RIDER:
                switch ($status) {
                    case 'PENDING':
                        return ['title' => "⏳ Ride Pending!", 'body' => "Your Ride #$rideNumber is being processed. Hang tight! 😄🚖"];
                    case 'REQUESTED':
                        return ['title' => "📩 Ride Requested!", 'body' => "We’re working on Ride #$rideNumber! 🚗 Stay tuned! 🎉"];
                    case 'SCHEDULED':
                        return ['title' => "📅 Ride Confirmed!", 'body' => "Your Ride #$rideNumber is all set! 🥳 Get ready! 🚙"];
                    case 'ACCEPTED':
                        return ['title' => "🚗 Driver’s Coming!", 'body' => "Your driver for Ride #$rideNumber is on the way! 🚀😎"];
                    case 'REJECTED':
                        return ['title' => "😔 Ride Unavailable", 'body' => "Ride #$rideNumber didn’t work out. Let’s find another! 🚖"];
                    case 'ARRIVED':
                        return ['title' => "🏠 Driver’s Here!", 'body' => "Your driver for Ride #$rideNumber is waiting! 🎈 Hop in! 🚗"];
                    case 'STARTED':
                        return ['title' => "🚙 Ride Started!", 'body' => "Enjoy your Ride #$rideNumber! 🎉 Safe travels! 🌟"];
                    case 'CANCELLED':
                        return ['title' => "😕 Ride Cancelled", 'body' => "Your Ride #$rideNumber was cancelled. Book another? 🚖"];
                    case 'COMPLETED':
                        return ['title' => "🎉 Ride Complete!", 'body' => "You’ve arrived with Ride #$rideNumber! 😊 How was it? ⭐"];
                }
                break;
        }

        // Default message if no match
        return ['title' => "🔔 Ride Update", 'body' => "Ride #$rideNumber status: $status"];
    }

    public function sendPushNotification($topic, $role, $ride)
    {
        try {

            if (!$topic) {
                return;
            }

            $message = $this->getNotificationMessage($role, $ride);
            Log::info('Ride Status: ' . $ride?->ride_status?->slug);
            $notification = [
                'message' => [
                    'topic' => $topic,
                    'notification' => [
                        'title' => $message['title'],
                        'body' => $message['body'],
                        'image' => '',
                    ],
                    'data' => [
                        'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                        'type' => 'ride_status'
                    ],
                ],
            ];

            pushNotification($notification);

        } catch(Exception $e) {

            Log::error("sendPushNotification.".$e?->getMessage());
        }
    }

}
