@extends('admin.layouts.master')
@section('title', __('cabbooking::static.coupons.edit_coupon'))
@section('content')
<div class="coupon-main">
    <form id="couponForm" action="{{ route('admin.coupon.update', $coupon->id) }}" method="POST" enctype="multipart/form-data">
        <div class="row g-xl-4 g-3">
            @method('PUT')
            @csrf
            @include('cabbooking::admin.coupon.fields')
        </div>
    </form>
</div>
@endsection
