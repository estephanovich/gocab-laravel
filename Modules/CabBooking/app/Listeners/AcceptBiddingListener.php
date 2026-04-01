<?php

namespace Modules\CabBooking\Listeners;

use Exception;
use App\Models\User;
use App\Enums\RoleEnum;
use App\Models\SmsTemplate;
use Modules\CabBooking\Models\Rider;
use Illuminate\Support\Facades\Log;
use Modules\CabBooking\Events\AcceptBiddingEvent;
use Modules\CabBooking\Enums\RoleEnum as EnumsRoleEnum;
use Modules\CabBooking\Notifications\AcceptBiddingNotification;

class AcceptBiddingListener
{
    /**
     * Handle the event.
     */
    public function handle(AcceptBiddingEvent $event): void
    {
        try {

            $admin = User::role(RoleEnum::ADMIN)->first();
            if (isset($admin)) {
                sendNotifyMail($admin, new AcceptBiddingNotification($event->ride, RoleEnum::ADMIN));
                $sendTo = ('+' . $admin?->country_code . $admin?->phone);
                sendSMS($sendTo, $this?->getSMSMessage($event, RoleEnum::ADMIN));
            }

            if ($event->ride?->driver) {
                $driver = $event->ride->driver;
                $this->sendPushNotification("user_".$driver->id, EnumsRoleEnum::DRIVER);
                sendNotifyMail($driver, new AcceptBiddingNotification($event->ride, EnumsRoleEnum::DRIVER));
                sendSMS($sendTo, $this->getSMSMessage($event, EnumsRoleEnum::DRIVER));
            }

            if ($event->ride?->rider_id) {
                $rider_id = $event->ride?->rider_id;
                $rider = Rider::where('id', $rider_id)?->whereNull('deleted_at')?->first();
                $this->sendPushNotification("user_".$rider_id, EnumsRoleEnum::RIDER);
                sendNotifyMail($rider, new AcceptBiddingNotification($event->ride,  EnumsRoleEnum::RIDER));
            }

        } catch (Exception $e) {

            Log::error("Accept Bidding Listener.".$e?->getMessage());
        }
    }

    public function getSMSMessage($event, $role)
    {
        $locale = request()->hasHeader('Accept-Lang') ? request()->header('Accept-Lang') : app()->getLocale();
        $slug = $role === EnumsRoleEnum::DRIVER ? 'create-ride-driver' : 'create-ride-admin';
        $content = SmsTemplate::where('slug', $slug)->first();

        if ($content) {
            $data = [
                '{{driver_name}}' => $event?->ride->driver->name,
                '{{ride_number}}' => $event?->ride->ride_number,
                '{{rider_name}}' => $event?->ride->rider['name'],
                '{{rider_phone}}' => $event?->ride->rider['phone'],
                '{{vehicle_type}}' => $event?->ride->vehicle_type->name,
                '{{services}}' => $event?->ride->service->name,
                '{{service_category}}' => $event?->ride->service_category->name,
                '{{fare_amount}}' => $event?->ride->ride_fare,
                '{{distance}}' => $event?->ride->distance,
                '{{distance_unit}}' => $event?->ride->distance_unit,
                '{{Your Company Name}}' => config('app.name')
            ];

            $message = str_replace(array_keys($data), array_values($data), $content?->content[$locale]);

        } else {

            $message = "A new ride has been created.";
        }

        return $message;
    }

    public function sendPushNotification($topic, $role)
    {
        try {

            if (!$topic)
                return;

            if ($role === EnumsRoleEnum::DRIVER) {
                $title = "🎉 Bid Accepted! 🚗 You're On!";
                $body = "The rider accepted your bid! 🏁 Gear up and hit the road for an awesome ride! 🚀💨";
            } else {
                $title = "🥳 Ride Created Successfully! 🚖";
                $body = "Your ride is all set! 🎉 Sit back, relax, and enjoy the journey! 🛣️📍";
            }

            $notification = [
                'message' => [
                    'topic' => $topic,
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                        'image' => '',
                    ],
                    'data' => [
                        'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                        'type' => 'accept_bidding',
                    ],
                ],
            ];

            pushNotification($notification);

        } catch(Exception $e) {

            Log::error("Accept Bidding sendPushNotification.".$e?->getMessage());
        }
    }
}
