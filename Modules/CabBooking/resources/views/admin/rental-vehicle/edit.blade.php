@extends('admin.layouts.master')
@section('title', __('cabbooking::static.rental_vehicle.edit'))
@section('content')
<div class="banner-main">
    <form id="rentalVehicleForm" action="{{ route('admin.rental-vehicle.update', $rentalVehicle->id) }}" method="POST" enctype="multipart/form-data">
        <div class="row g-xl-4 g-3">
            @method('PUT')
            @csrf
            @include('cabbooking::admin.rental-vehicle.fields')
        </div>
    </form>
</div>
@endsection
