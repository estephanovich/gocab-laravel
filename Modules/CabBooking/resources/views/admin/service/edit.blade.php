@extends('admin.layouts.master')
@section('title', __('cabbooking::static.services.edit'))
@section('content')
<div class="banner-main">
    <form id="serviceForm" action="{{ route('admin.service.update', $service->id) }}" method="POST" enctype="multipart/form-data">
        <div class="row g-xl-4 g-3">
            @method('PUT')
            @csrf
            @include('cabbooking::admin.service.fields')
        </div>
    </form>
</div>
@endsection
