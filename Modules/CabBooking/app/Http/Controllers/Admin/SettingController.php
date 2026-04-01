<?php

namespace Modules\CabBooking\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\CabBooking\Models\CabBookingSetting;
use Modules\CabBooking\Repositories\Admin\SettingRepository;

class SettingController extends Controller
{
    public $repository;

    public function __construct(SettingRepository $repository)
    {
        $this->authorizeResource(CabBookingSetting::class, 'cabbooking_setting');
        $this->repository = $repository;
    }

    public function index()
    {
        return $this->repository->index();
    }

    public function update(Request $request, CabBookingSetting $cabbookingSetting)
    {
        return $this->repository->update($request->all(), $cabbookingSetting?->id);
    }
    
}
