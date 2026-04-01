@extends('admin.layouts.master')
@section('title', __('cabbooking::static.fleet_vehicle_documents.edit'))
@section('content')
<div class="banner-main">
    <form id="vehicleInfoDocForm" action="{{ route('admin.vehicleInfoDoc.update', $vehicleInfoDoc->id) }}" method="POST" enctype="multipart/form-data">
        <div class="row g-xl-4 g-3">
            @method('PUT')
            @csrf
            @include('cabbooking::admin.vehicle-info-doc.fields')
        </div>
    </form>
</div>
@endsection
