@extends('admin.layouts.master')
@section('title', __('cabbooking::static.riders.add'))
@section('content')
<div class="user-create">
  <form id="riderForm" action="{{ route('admin.rider.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('cabbooking::admin.rider.fields')
  </form>
</div>
@endsection
