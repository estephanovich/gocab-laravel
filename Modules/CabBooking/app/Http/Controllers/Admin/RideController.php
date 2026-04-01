<?php

namespace Modules\CabBooking\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Modules\CabBooking\Models\Ride;
use Modules\CabBooking\Tables\RideTable;
use App\Http\Controllers\Controller;
use Modules\CabBooking\Repositories\Admin\RideRepository;

class RideController extends Controller
{
    private $repository;

    public function __construct(RideRepository $repository)
    {
        $this->authorizeResource(Ride::class, 'ride');
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(RideTable $rideTable)
    {
        return $this->repository->index($rideTable->generate());
    }

    public function getRidesByStatus(RideTable $rideTable)
    {
        return $this->repository->index($rideTable->generate());
    }

    public function details(Request $request)
    {
        return $this->repository->details($request->ride_number);
    }

    public function export(Request $request)
    {
        return $this->repository->export($request);
    }
}
