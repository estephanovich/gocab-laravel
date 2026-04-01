<?php

namespace Modules\CabBooking\Providers;

use Modules\CabBooking\Models\Ride;
use Illuminate\Support\ServiceProvider;
use Modules\CabBooking\Observers\RideObserver;

class ObserverServiceProvider extends ServiceProvider
{
  public function boot(): void
  {
    Ride::observe(RideObserver::class);
  }
}
