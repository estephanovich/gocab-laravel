@extends('admin.layouts.master')
@section('title', __('cabbooking::static.driver_documents.edit'))
@section('content')
<div class="banner-main">
    <form id="driverDocumentForm" action="{{ route('admin.driver-document.update', $driverDocument->id) }}" method="POST" enctype="multipart/form-data">
        <div class="row g-xl-4 g-3">
            @method('PUT')
            @csrf
            @include('cabbooking::admin.driver-document.fields')
        </div>
    </form>
</div>
@endsection
