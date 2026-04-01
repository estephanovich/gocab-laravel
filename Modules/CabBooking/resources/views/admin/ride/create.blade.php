@extends('admin.layouts.master')
@section('title',  __('cabbooking::static.rides.create'))
@section('content')
<div class="banner-create">
        <div class="row g-xl-4 g-3">
            @include('cabbooking::admin.ride.fields')
        </div>
    </form>
</div>
@endsection
