<?php

namespace Modules\CabBooking\Repositories\Admin;

use Exception;
use App\Exceptions\ExceptionHandler;
use Modules\CabBooking\Models\ReferralBonus;
use Prettus\Repository\Eloquent\BaseRepository;

class ReferralRepository extends BaseRepository
{

    public function model()
    {
        return ReferralBonus::class;
    }

    public function index($referralTable, $userTypeFilters = [])
    {
        if (request()['action']) {
            return redirect()->back();
        }

        return view('cabbooking::admin.referral.index', [
            'tableConfig' => $referralTable,
            'userTypeFilters' => $userTypeFilters
        ]);
    }
}
