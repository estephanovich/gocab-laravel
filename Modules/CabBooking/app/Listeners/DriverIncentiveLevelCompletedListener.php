<?php

namespace Modules\CabBooking\Listeners;

use Exception;
use Illuminate\Support\Facades\Log;
use Modules\CabBooking\Events\DriverIncentiveLevelCompletedEvent;
use Modules\CabBooking\Notifications\DriverIncentiveLevelCompletedNotification;
use Modules\CabBooking\Models\Incentive;
use Modules\CabBooking\Models\IncentiveLevel;

class DriverIncentiveLevelCompletedListener
{
    /**
     * Handle the event.
     *
     * @param DriverIncentiveLevelCompletedEvent $event
     */
    public function handle(DriverIncentiveLevelCompletedEvent $event): void
    {
        try {
            $incentive = $event->incentive;

            // Retrieve driver model from incentive
            $driver = $incentive->driver;

            if (!$driver) {
                Log::warning('DriverIncentiveLevelCompletedListener: Driver not found', [
                    'incentive_id' => $incentive->id,
                    'driver_id' => $incentive->driver_id,
                ]);
                return;
            }

            // Retrieve incentive level details
            $incentiveLevel = $incentive->incentiveLevel;

            if (!$incentiveLevel) {
                Log::warning('DriverIncentiveLevelCompletedListener: Incentive level not found', [
                    'incentive_id' => $incentive->id,
                    'incentive_level_id' => $incentive->incentive_level_id,
                ]);
                return;
            }

            // Get driver's preferred language or use default
            $language = $driver->language ?? app()->getLocale();

            // Create and send notification via sendNotifyMail
            sendNotifyMail($driver, new DriverIncentiveLevelCompletedNotification($incentive, $language));

            // Send push notification
            $topic = "user_{$driver->id}";
            $this->sendPushNotification($topic, $incentive);

        } catch (Exception $e) {
            Log::error('DriverIncentiveLevelCompletedListener: ' . $e->getMessage(), [
                'incentive_id' => $incentive->id ?? null,
                'driver_id' => $incentive->driver_id ?? null,
                'exception' => $e
            ]);
        }
    }

    /**
     * Send push notification to the driver
     *
     * @param string $topic
     * @param Incentive $incentive
     */
    private function sendPushNotification(string $topic, Incentive $incentive): void
    {
        try {
            // Validate topic parameter
            if (empty($topic)) {
                Log::warning('DriverIncentiveLevelCompletedListener: Empty topic for push notification');
                return;
            }

            // Get notification message
            $message = $this->getNotificationMessage($incentive);

            // Construct Firebase notification payload
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
                        'type' => 'incentive_level',
                    ],
                ],
            ];

            // Call pushNotification helper function
            pushNotification($notification);

        } catch (Exception $e) {
            Log::error('DriverIncentiveLevelCompletedListener: Push notification failed', [
                'topic' => $topic,
                'incentive_id' => $incentive->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Get notification message based on incentive level
     *
     * @param Incentive $incentive
     * @return array
     */
    private function getNotificationMessage(Incentive $incentive): array
    {
        $levelNumber = $incentive->level_number;
        $bonusAmount = number_format($incentive->bonus_amount, 2);
        $targetRides = $incentive->target_rides;

        // Get next level information if available
        $incentiveLevel = $incentive->incentiveLevel;
        $nextLevelInfo = '';

        if ($incentiveLevel) {
            $nextLevel = IncentiveLevel::where('vehicle_type_zone_id', $incentiveLevel->vehicle_type_zone_id)
                ->where('period_type', $incentiveLevel->period_type)
                ->where('level_number', $incentiveLevel->level_number + 1)
                ->where('is_active', true)
                ->first();

            if ($nextLevel) {
                $nextLevelBonus = number_format($nextLevel->incentive_amount, 2);
                $nextLevelInfo = " Next: Level {$nextLevel->level_number} - {$nextLevel->target_rides} rides for {$nextLevelBonus}!";
            }
        }

        // Different messages for different levels
        $messages = [
            1 => [
                'title' => '🎯 Level 1 Complete!',
                'body' => "Amazing start! You earned {$bonusAmount} for completing {$targetRides} rides! Keep going! 🚀{$nextLevelInfo}",
            ],
            2 => [
                'title' => '🔥 Level 2 Unlocked!',
                'body' => "You're on fire! {$bonusAmount} earned for {$targetRides} rides! Next level awaits! 💪{$nextLevelInfo}",
            ],
            3 => [
                'title' => '⭐ Level 3 Achieved!',
                'body' => "Superstar! {$bonusAmount} is yours for {$targetRides} rides! You're unstoppable! 🌟{$nextLevelInfo}",
            ],
            4 => [
                'title' => '🏆 Level 4 Mastered!',
                'body' => "Elite driver! {$bonusAmount} earned for {$targetRides} rides! Almost at the top! 👑{$nextLevelInfo}",
            ],
        ];

        // Default message for level 5 and above
        $default = [
            'title' => "👑 Level {$levelNumber} Conquered!",
            'body' => "Legendary! {$bonusAmount} for {$targetRides} rides! You're a champion! 🎊🚗{$nextLevelInfo}",
        ];

        return $messages[$levelNumber] ?? $default;
    }
}
