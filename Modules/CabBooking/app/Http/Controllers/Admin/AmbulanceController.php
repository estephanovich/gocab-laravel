<?php

namespace Modules\CabBooking\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\CabBooking\Models\Ambulance;
use Modules\CabBooking\Tables\AmbulanceTable;
use Modules\CabBooking\Repositories\Admin\AmbulanceRepository;

class AmbulanceController extends Controller
{

    public $repository;

    public function __construct(AmbulanceRepository $repository)
    {
        $this->authorizeResource(Ambulance::class, 'ambulance');
        $this->repository = $repository;
    }

     /**
     * Display a listing of the resource.
     */
    public function index(AmbulanceTable $ambulanceTable)
    {
        return $this->repository->index($ambulanceTable->generate());
    }
}