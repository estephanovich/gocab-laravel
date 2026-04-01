<?php

namespace Modules\CabBooking\Repositories\Admin;

use Modules\CabBooking\Models\CabCommissionHistory;
use Prettus\Repository\Eloquent\BaseRepository;

class CabCommissionHistoryRepository extends BaseRepository
{
    public function model()
    {
        return CabCommissionHistory::class;
    }

    public function index($cabCommissionHistoryTable)
    {
        if (request()['action']) {
            return redirect()->back();
        }

        return view('cabbooking::admin.cab-commission-history.index', ['tableConfig' => $cabCommissionHistoryTable]);
    }

}   