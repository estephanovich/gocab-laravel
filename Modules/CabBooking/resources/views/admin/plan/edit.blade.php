@extends('admin.layouts.master')
@section('title', __('cabbooking::static.plans.edit'))
@section('content')
<div class="banner-main">
    <form id="planForm" action="{{ route('admin.plan.update', $plan->id) }}" method="POST" enctype="multipart/form-data">
        <div class="row g-xl-4 g-3">
            @method('PUT')
            @csrf
            @include('cabbooking::admin.plan.fields')
        </div>
    </form>
</div>
@endsection
