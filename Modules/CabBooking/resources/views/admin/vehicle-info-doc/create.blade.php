@extends('admin.layouts.master')
@section('title', __('cabbooking::static.fleet_vehicle_documents.add'))
@section('content')
<div class="banner-create">
    <form id="vehicleInfoDocForm" action="{{ route('admin.vehicleInfoDoc.store') }}" method="POST" enctype="multipart/form-data">
        <div class="row g-xl-4 g-3">
            @method('POST')
            @csrf
            @include('cabbooking::admin.vehicle-info-doc.fields')
        </div>
    </form>
</div>
@endsection
