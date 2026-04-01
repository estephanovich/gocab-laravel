<?php

namespace Modules\CabBooking\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\CabBooking\Models\VehicleType;
use Modules\CabBooking\Models\RentalVehicle;
use Modules\CabBooking\Tables\RentalVehicleTable;
use Modules\CabBooking\Enums\ServiceCategoryEnum;
use Modules\CabBooking\Repositories\Admin\RentalVehicleRepository;

class RentalVehicleController extends Controller
{
    private $repository;

    public function __construct(RentalVehicleRepository $repository)
    {
        $this->authorizeResource(RentalVehicle::class,'rental_vehicle', ['except' => 'index', 'show']);
        $this->repository = $repository;
    }

    public function index(RentalVehicleTable $rentalVehicleTable)
    {
        return $this->repository->index($rentalVehicleTable->generate());
    }

    public function create()
    {
        $vehicleTypes = VehicleType::whereHas('service_categories', function ($query) {
            $query->where('slug', '=' , ServiceCategoryEnum::RENTAL); 
        })->get();
      
        return view('cabbooking::admin.rental-vehicle.create', ['vehicleTypes' => $vehicleTypes]);
    }

    public function store(Request $request)
    {
        return $this->repository->store($request);
    }

    public function edit(RentalVehicle $rentalVehicle)
    {
        $vehicleTypes = VehicleType::whereHas('service_categories', function ($query) {
            $query->where('slug', '=' , ServiceCategoryEnum::RENTAL); 
        })->get();
      
        return view('cabbooking::admin.rental-vehicle.edit', ['rentalVehicle' => $rentalVehicle,'vehicleTypes' => $vehicleTypes]);
    }


    public function update(Request $request, RentalVehicle $rentalVehicle)
    {
        return $this->repository->update($request->all(), $rentalVehicle->id);
    }

    public function getVehicleZones($vehicleId)
    {
        $vehicleType = VehicleType::with('zones')->find($vehicleId);

        if (!$vehicleType) {
            return response()->json([], 404);
        }

        $zones = $vehicleType->zones->pluck('name', 'id');

        return response()->json($zones);
    }
    
    public function RentalVehicleFilter(Request $request)
    {
        return $this->repository->RentalVehicleFilter($request);
    }
    
    public function destroy(RentalVehicle $rentalVehicle)
    {
        return $this->repository->destroy($rentalVehicle->id);
    }

    
    public function status(Request $request)
    {
        return $this->repository->status($request->id, $request->status);
    }

    public function restore($id)
    {
        return $this->repository->restore($id);
    }

    public function forceDelete($id)
    {
        return $this->repository->forceDelete($id);
    }

}
