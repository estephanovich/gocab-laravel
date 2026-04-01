<?php

namespace Modules\CabBooking\Repositories\Admin;

use Modules\CabBooking\Models\Ambulance;
use Prettus\Repository\Eloquent\BaseRepository;

class AmbulanceRepository extends BaseRepository
{
    public function model()
    {
        return Ambulance::class;
    }

    public function index($ambulanceTable)
    {
        if (request()['action']) {
            return redirect()->back();
        }

        return view('cabbooking::admin.ambulance.index', ['tableConfig' => $ambulanceTable]);
    }
}