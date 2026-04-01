@extends('admin.layouts.master')
@section('title', __('cabbooking::static.dispatchers.add'))
@section('content')
<div class="dispatcher-create">
    <form id="dispatcherForm" action="{{ route('admin.dispatcher.store') }}" method="POST" enctype="multipart/form-data">
        <div class="row g-xl-4 g-3">
            @method('POST')
            @csrf
            @include('cabbooking::admin.dispatcher.fields')
        </div>
    </form>
</div>
@endsection
