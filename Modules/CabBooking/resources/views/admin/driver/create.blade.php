@extends('admin.layouts.master')
@section('title', __('cabbooking::static.drivers.add_driver'))
@section('content')
    <div class="">
        <form id="driverForm" action="{{ route('admin.driver.store') }}" method="POST" enctype="multipart/form-data">
            @method('POST')
            @csrf
            @include('cabbooking::admin.driver.fields')
        </form>
    </div>
@endsection
