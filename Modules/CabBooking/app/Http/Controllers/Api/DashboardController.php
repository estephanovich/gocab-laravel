<?php

namespace Modules\CabBooking\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\CabBooking\Repositories\Api\DashboardRepository;

class DashboardController extends Controller
{
    public $repository;


    public function __construct(DashboardRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return $this->repository->index();
    }
}