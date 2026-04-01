<?php

namespace Modules\CabBooking\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\CabBooking\Repositories\Front\RideRequestRepository;

class RideRequestController extends Controller
{
  public $repository;
  /**
   * Display a listing of the resource.
   */
  public function __construct(RideRequestRepository $repository)
  {
    $this->repository = $repository;
  }

  public function store(Request $request)
  {
    return $this->repository->store($request);
  }
}
