<?php

namespace Modules\CabBooking\Repositories\Front;

use Exception;
use App\Http\Traits\FireStoreTrait;
use Modules\CabBooking\Models\RideRequest;
use Modules\CabBooking\Http\Traits\RideRequestTrait;
use Prettus\Repository\Eloquent\BaseRepository;

class RideRequestRepository extends BaseRepository
{
    use RideRequestTrait;

    function model()
    {
        return RideRequest::class;
    }

    public function store($request)
    {
        try {

            $cabbookingSettings = getCabBookingSettings();
            if($cabbookingSettings['activation']['bidding']) {
                throw new Exception("Bidding rides are not supported. Please ask the admin to turn off bidding.", 404);
            }

            $rideRequest = $request->ride_data;
            $request = $request->merge($rideRequest);
            $request['rider_id'] = getCurrentUserId();
            $rideRequest = $this->createCabRideRequest($request);
            return response()->json([
                'success' => true,
                'ride_id' => $rideRequest['id'],
                'message' => 'Ride request created successfully.'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create ride request: ' . $e->getMessage()
            ], 500);
        }
    }
}
