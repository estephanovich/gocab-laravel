<?php

namespace Modules\CabBooking\Repositories\Api;

use Exception;
use Modules\CabBooking\Models\Ride;
use Modules\CabBooking\Models\Coupon;
use Modules\CabBooking\Models\Banner;
use Modules\CabBooking\Models\Service;
use Modules\CabBooking\Enums\RoleEnum;
use App\Exceptions\ExceptionHandler;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Database\Eloquent\Builder;
use Modules\CabBooking\Models\ServiceCategory;
use Modules\CabBooking\Http\Resources\RideResource;
use Prettus\Repository\Eloquent\BaseRepository;
use Modules\CabBooking\Http\Resources\BannerResource;
use Modules\CabBooking\Http\Resources\Riders\CouponResource;
use Modules\CabBooking\Http\Resources\Riders\ServiceCategoryResource;

class HomeScreenRepository extends BaseRepository
{
    function model()
    {
        return Service::class;
    }

    public function isUserTokenable($request)
    {
        $token = $request->bearerToken();
        if ($token) {
            $personalAccessToken = PersonalAccessToken::findToken($token);

            if ($personalAccessToken) {
                return $personalAccessToken->tokenable;
            }
        }
        return false;
    }

    public function index($request)
    {
        try {

            $rides = [];
            $coupons = [];
            $banners = [];
            $serviceCategories = [];
            if($request->service) {
                $service_id = getServiceIdBySlug($request?->service);
            } else {
                $service_id = $this->model?->whereNull('deleted_at')?->where('status', true)?->where('is_primary', true)?->value('id');
            }

            if($service_id) {
                $banners = Banner::where('status', true)?->whereNull('deleted_at')?->whereHas('services', function (Builder $query) use ($service_id) {
                    $query->where('service_id', $service_id);
                })?->get();

                $serviceCategories = ServiceCategory::whereNull('deleted_at')?->where('status', true)
                    ?->where('service_id', $service_id)?->get();

                $user = $this->isUserTokenable($request);

                if($user){
                    $rides = Ride::whereNull('deleted_at')?->where('rider_id', $user->id)->where('service_id', $service_id)?->latest()?->limit(3)?->get();
                    $roleName = getCurrentRoleName();
                    if ($roleName == RoleEnum::RIDER) {
                        $rides = $rides->where('rider_id', getCurrentUserId());
                    }
                }

                $coupons = Coupon::active()?->whereHas('services', function (Builder $categories) use($service_id) {
                    $categories->where('service_id', $service_id);
                })?->get();
            }

            return [
                'banners' => BannerResource::collection($banners),
                'service_categories' => ServiceCategoryResource::collection($serviceCategories),
                'recent_rides' =>  RideResource::collection($rides),
                'coupons' => CouponResource::collection($coupons ?? []),
            ];

        } catch (Exception $e) {

            throw new ExceptionHandler($e->getMessage(), $e->getCode());
        }
    }
}
