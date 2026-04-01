<?php

namespace Modules\CabBooking\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Modules\CabBooking\Models\Banner;
use App\Http\Controllers\Controller;
use Modules\CabBooking\Tables\BannerTable;
use Modules\CabBooking\Repositories\Admin\BannerRepository;
use Modules\CabBooking\Http\Requests\Admin\CreateBannerRequest;
use Modules\CabBooking\Http\Requests\Admin\UpdateBannerRequest;

class BannerController extends Controller
{
    public $repository;

    public function __construct(BannerRepository $repository)
    {
        $this->authorizeResource(Banner::class, 'banner');
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(BannerTable $bannerTable)
    {
        return $this->repository->index($bannerTable->generate());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cabbooking::admin.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateBannerRequest $request)
    {
        return $this->repository->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        return view('cabbooking::admin.banner.edit', ['banner' => $banner]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBannerRequest $request, Banner $banner)
    {
        return $this->repository->update($request->all(), $banner->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        return $this->repository->destroy($banner->id);
    }

    /**
     * Change Status the specified resource from storage.
     */
    public function status(Request $request, $id)
    {
        return $this->repository->status($id, $request->status);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        return $this->repository->restore($id);
    }

    /**
     * Permanent delete the specified resource from storage.
     */
    public function forceDelete($id)
    {
        return $this->repository->forceDelete($id);
    }
}
