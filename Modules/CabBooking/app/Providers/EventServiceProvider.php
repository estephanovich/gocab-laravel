<?php

namespace Modules\CabBooking\Providers;

use Modules\CabBooking\Events\AddRideRequestEvent;
use Modules\CabBooking\Events\RideRequestEvent;
use Modules\CabBooking\Events\UpdateRideLocationEvent;
use Modules\CabBooking\Listeners\AddRideRequestListener;
use Modules\CabBooking\Listeners\RideRequestListener;

use Modules\CabBooking\Events\AcceptBiddingEvent;
use Modules\CabBooking\Listeners\AcceptBiddingListener;

use Modules\CabBooking\Events\CreateWithdrawRequestEvent;
use Modules\CabBooking\Listeners\CreateWithdrawRequestListener;

use Modules\CabBooking\Events\CreateBidEvent;
use Modules\CabBooking\Listeners\CreateBidListener;

use Modules\CabBooking\Events\RejectBiddingEvent;
use Modules\CabBooking\Listeners\RejectBiddingListener;

use Modules\CabBooking\Events\UpdateWithdrawRequestEvent;
use Modules\CabBooking\Listeners\UpdateRideLocationListener;
use Modules\CabBooking\Listeners\UpdateWithdrawRequestListener;

use Modules\CabBooking\Events\SOSAlertEvent;
use Modules\CabBooking\Listeners\SOSAlertListener;

use Modules\CabBooking\Events\CreateFleetWithdrawRequestEvent;
use Modules\CabBooking\Listeners\CreateFleetWithdrawRequestListener;

use Modules\CabBooking\Events\NotifyDriverDocStatusEvent;
use Modules\CabBooking\Listeners\NotifyDriverDocStatusListener;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use Modules\CabBooking\Events\DriverVerificationEvent;
use Modules\CabBooking\Events\RideStatusEvent;
use Modules\CabBooking\Events\ReferralBonusCreditedEvent;
use Modules\CabBooking\Events\DriverIncentiveLevelCompletedEvent;
use Modules\CabBooking\Listeners\DriverVerificationListener;
use Modules\CabBooking\Listeners\RideStatusListener;
use Modules\CabBooking\Listeners\ReferralBonusCreditedListener;
use Modules\CabBooking\Listeners\DriverIncentiveLevelCompletedListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array<string, array<int, string>>
     */
    protected $listen = [
        RideRequestEvent::class => [
            RideRequestListener::class
        ],
        AcceptBiddingEvent::class => [
            AcceptBiddingListener::class
        ],
        CreateWithdrawRequestEvent::class => [
            CreateWithdrawRequestListener::class
        ],
        CreateBidEvent::class => [
            CreateBidListener::class
        ],
        RejectBiddingEvent::class => [
            RejectBiddingListener::class
        ],
        UpdateWithdrawRequestEvent::class => [
            UpdateWithdrawRequestListener::class
        ],
        SOSAlertEvent::class => [
            SOSAlertListener::class
        ],
        CreateFleetWithdrawRequestEvent::class => [
            CreateFleetWithdrawRequestListener::class
        ],
        NotifyDriverDocStatusEvent::class => [
            NotifyDriverDocStatusListener::class
        ],
        DriverVerificationEvent::class => [
            DriverVerificationListener::class
        ],
        RideStatusEvent::class => [
            RideStatusListener::class
        ],
        ReferralBonusCreditedEvent::class => [
            ReferralBonusCreditedListener::class
        ],
        DriverIncentiveLevelCompletedEvent::class => [
            DriverIncentiveLevelCompletedListener::class
        ],
        UpdateRideLocationEvent::class => [
            UpdateRideLocationListener::class
        ],
    ];

    /**
     * Indicates if events should be discovered.
     *
     * @var bool
     */
    protected static $shouldDiscoverEvents = true;

    /**
     * Configure the proper event listeners for email verification.
     *
     * @return void
     */
    protected function configureEmailVerification(): void
    {

    }
}
