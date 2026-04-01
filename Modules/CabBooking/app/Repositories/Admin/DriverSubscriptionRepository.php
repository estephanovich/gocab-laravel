<?php

namespace Modules\CabBooking\Repositories\Admin;

use Modules\CabBooking\Models\DriverSubscription;
use Prettus\Repository\Eloquent\BaseRepository;


class DriverSubscriptionRepository extends BaseRepository
{
    function model()
    {
        return DriverSubscription::class;
    }

    public function index($driverSubscriptionTable)
    {
        if (request()['action']) {
            return redirect()->back();
        }

        return view('cabbooking::admin.driver-subscription.index', ['tableConfig' => $driverSubscriptionTable]);
    }
}