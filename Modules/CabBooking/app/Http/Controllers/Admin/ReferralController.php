<?php

namespace Modules\CabBooking\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\CabBooking\Repositories\Admin\ReferralRepository;
use Modules\CabBooking\Tables\ReferralTable;

class ReferralController extends Controller
{
    public $repository;

    /**
     * Display a listing of the resource.
     */
    public function __construct(ReferralRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display referral bonuses with simplified two core bonus types
     * Shows only referrer and referred bonus amounts with user type filtering
     */
    public function index(Request $request, ReferralTable $referralTable)
    {
        // Generate table config with simplified bonus structure
        $tableConfig = $referralTable->generate();

        // User type filter options for rider/driver referrals
        $userTypeFilters = [
            'all' => __('cabbooking::static.referrals.all_types'),
            'rider' => __('cabbooking::static.referrals.rider_referrals'),
            'driver' => __('cabbooking::static.referrals.driver_referrals'),
        ];

        return $this->repository->index($tableConfig, $userTypeFilters);
    }
}
