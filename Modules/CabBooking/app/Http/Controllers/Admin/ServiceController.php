<?php

namespace Modules\CabBooking\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Modules\CabBooking\Models\Service;
use App\Http\Controllers\Controller;
use Modules\CabBooking\Tables\ServiceTable;
use Modules\CabBooking\Repositories\Admin\ServiceRepository;
use Modules\CabBooking\Http\Requests\Admin\UpdateServiceRequest;

class ServiceController extends Controller
{
    public $repository;

    public function __construct(ServiceRepository $repository)
    {
        $this->authorizeResource(Service::class, 'service');
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(ServiceTable $serviceTable)
    {
        return $this->repository->index($serviceTable->generate());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return view('cabbooking::admin.service.edit', ['service' => $service]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        return $this->repository->update($request->all(), $service->id);
    }

    /**
     * Change status of the specified resource.
     */
    public function status(Request $request, $id)
    {
        return $this->repository->status($id, $request->status);
    }

    /**
     *  primary status of the specified resource.
     */
    public function primary(Request $request, $id)
    {
        return $this->repository->primary($id, $request->status); 
    }
}
