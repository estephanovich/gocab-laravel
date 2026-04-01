@extends('admin.layouts.master')
@section('title', __('cabbooking::static.fleet_managers.add'))
@section('content')
    <div class="fleet-manager-create">
        <form id="fleetManagerForm" action="{{ route('admin.fleet-manager.store') }}" method="POST" enctype="multipart/form-data">
            @method('POST')
            @csrf
            @include('cabbooking::admin.fleet-manager.fields')
        </form>
    </div>
@endsection
