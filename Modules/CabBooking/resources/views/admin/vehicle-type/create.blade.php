@extends('admin.layouts.master')
@section('title', __('cabbooking::static.vehicle_types.add'))
@section('content')
    <div class="vehicle-create">
        <form id="vehicleTypeForm" action="{{ route('admin.vehicle-type.store') }}" method="POST" enctype="multipart/form-data">
            @method('POST')
            @csrf
            <input type="hidden" name="req_service" value="{{request()->service}}" />
            @include('cabbooking::admin.vehicle-type.fields')
        </form>
        @include('cabbooking::admin.vehicle-type.zone-price')
    </div>
@endsection
