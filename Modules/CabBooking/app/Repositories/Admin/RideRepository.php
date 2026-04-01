<?php

namespace Modules\CabBooking\Repositories\Admin;

use Exception;
use Modules\CabBooking\Models\Ride;
use App\Exceptions\ExceptionHandler;
use Modules\CabBooking\Models\RideRequest;
use Prettus\Repository\Eloquent\BaseRepository;

class RideRepository extends BaseRepository
{
    protected $rideRequest;

    function model()
    {
        $this->rideRequest = new RideRequest();
        return Ride::class;
    }

    public function index($rideTable)
    {
        if (request()['action']) {
            return redirect()->back();
        }

        return view('cabbooking::admin.ride.index', ['tableConfig' => $rideTable]);
    }

    public function details($id)
    {
        try {
            $ride = $this->model->with(['commission_history','coupon'])->where('id', $id)?->first();
            if ($ride) {
                return view('cabbooking::admin.ride.details', ['ride' => $ride]);
            }

            throw new Exception("Ride not exists", 404);

        } catch (Exception $e) {
            throw new ExceptionHandler($e->getMessage(), $e->getCode());
        }
    }

    public function export($request)
    {
        try {

            $format = $request->get('format', 'csv');
            switch ($format) {
                case 'excel':
                    return $this->exportExcel();
                case 'csv':
                default:
                    return $this->exportCsv();
            }

        } catch (Exception $e) {
            throw new ExceptionHandler($e->getMessage(), $e->getCode());
        }
    }
}
