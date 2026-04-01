@extends('admin.layouts.master')
@section('title', __('cabbooking::static.soses.add'))
@section('content')
    <div class="sos-create">
        <form id="sosForm" action="{{ route('admin.sos.store') }}" method="POST" enctype="multipart/form-data">
            @method('POST')
            @csrf
            @include('cabbooking::admin.sos.fields')
        </form>
    </div>
@endsection
