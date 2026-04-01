<?php

namespace Modules\CabBooking\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Modules\CabBooking\Models\Zone;
use App\Http\Controllers\Controller;
use Modules\CabBooking\Models\SurgePrice;
use Modules\CabBooking\Models\VehicleType;
use Modules\CabBooking\Models\VehicleSurgePrice;
use Modules\CabBooking\Repositories\Admin\VehicleSurgePriceRepository;

class VehicleSurgePriceController extends Controller
{
    public $repository;

    /**
     * Display a listing of the resource.
     */
    public function __construct(VehicleSurgePriceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index($vehicleTypeId)
    {
        $vehicleType = VehicleType::findOrFail($vehicleTypeId);
        $surgePrices = SurgePrice::where('status', true)->get(['id', 'start_time', 'end_time', 'day']);
        return view('cabbooking::admin.vehicle-surge-price.index', ['vehicleSurgePrices' => VehicleSurgePrice::where('vehicle_type_id', $vehicleTypeId)->get(), 'vehicleTypeId' => $vehicleTypeId,  'vehicleName' => $vehicleType->name,'vehicleType' => $vehicleType, 'zones' => Zone::all(),'surgePrices' => $surgePrices]);
    }

    public function VehicleSurgePriceIndex($vehicleTypeId, $zoneId)
    {
        return $this->repository->VehicleSurgePriceIndex($vehicleTypeId, $zoneId);
    }

    public function vehicleSurgePriceShow($vehicleTypeId, $zoneId)
    {
        return $this->repository->vehicleSurgePriceShow($vehicleTypeId, $zoneId);
    }

    public function store(Request $request)
    {
        return $this->repository->vehicleSurgePriceStore($request);
    }

    public function update(Request $request, VehicleSurgePrice $vehicleSurgePrice)
    {
        return $this->repository->vehicleSurgePriceUpdate($request, $vehicleSurgePrice);
    }
}
