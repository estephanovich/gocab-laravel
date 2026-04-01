@extends('admin.layouts.master')
@section('title', __('cabbooking::static.peakZones.edit'))
@section('content')
<div class="zone-main">
    <form id="peakZoneForm" action="{{ route('admin.peakZone.update', $peakZone->id) }}" method="POST" enctype="multipart/form-data">
        <div class="row g-xl-4 g-3">
            @method('PUT')
            @csrf
            @include('cabbooking::admin.peak-zone.fields')
        </div>
    </form>
</div>
@endsection
