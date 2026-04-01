<?php

namespace Modules\CabBooking\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\CabBooking\Enums\ServicesEnum;
use Modules\CabBooking\Models\ServiceCategory;
use Modules\CabBooking\Tables\ServiceCategoryTable;
use Modules\CabBooking\Repositories\Admin\ServiceCategoryRepository;
use Modules\CabBooking\Http\Requests\Admin\UpdateServiceCategoryRequest;

class ServiceCategoryController extends Controller
{
    public $repository;

    public function __construct(ServiceCategoryRepository $repository)
    {
        $this->authorizeResource(ServiceCategory::class, 'service_category');
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     */
    public function cabIndex(ServiceCategoryTable $serviceCategoryTable)
    {
        request()->merge(['service' => ServicesEnum::CAB]);
        return $this->repository->index($serviceCategoryTable->generate());
    }

    /**
     * Display a listing of the resource.
     */
    public function parcelIndex(ServiceCategoryTable $serviceCategoryTable)
    {
        request()->merge(['service' => ServicesEnum::PARCEL]);
        return $this->repository->index($serviceCategoryTable->generate());
    }

    /**
     * Display a listing of the resource.
     */
    public function freightIndex(ServiceCategoryTable $serviceCategoryTable)
    {
        request()->merge(['service' => ServicesEnum::FREIGHT]);
        return $this->repository->index($serviceCategoryTable->generate());
    }

    /**
     * Display a listing of the resource.
     */
    public function cabEdit(ServiceCategory $serviceCategory)
    {
        request()->merge(['service' => ServicesEnum::CAB]);
        return view('cabbooking::admin.service-category.edit', ['serviceCategory' => $serviceCategory,'service' => ServicesEnum::PARCEL]);
    }

    /**
     * Display a listing of the resource.
     */
    public function parcelEdit(ServiceCategory $serviceCategory)
    {
        request()->merge(['service' => ServicesEnum::PARCEL]);
                $serviceCategories = getServiceIdByServiceCategories(ServicesEnum::PARCEL);
        return view('cabbooking::admin.service-category.edit', ['serviceCategory' => $serviceCategory,'service'=>ServicesEnum::PARCEL]);
    }

    /**
     * Display a listing of the resource.
     */
    public function freightEdit(ServiceCategory $serviceCategory)
    {
        request()->merge(['service' => ServicesEnum::FREIGHT]);
        return view('cabbooking::admin.service-category.edit', ['serviceCategory' => $serviceCategory]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceCategoryRequest $request, ServiceCategory $serviceCategory)
    {
        return $this->repository->update($request->all(), $serviceCategory->id);
    }

    /**
     * Change status of the specified resource.
     */
    public function status(Request $request, $id)
    {
        return $this->repository->status($id, $request->status);
    }
}
