@php
 $settings = getCabBookingSettings();
@endphp
@extends('admin.layouts.master')
@section('title', __('cabbooking::static.heatmaps.ride_request_heatmap'))
@section('content')
    <div class="map-section">
        <div class="contentbox">
            <div class="inside">
                <div class="contentbox-title">
                    <div class="contentbox-subtitle">
                        <h3>{{ __('cabbooking::static.heatmaps.heat_map') }}</h3>
                    </div>

                </div>
                <div class="alert alert-info ms-0 w-100" role="alert">
                    {{ __('cabbooking::static.heatmaps.text') }}
                </div>
                <div class="map-box">
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@if ($settings['location']['map_provider'] == 'google_map')
    @includeIf('cabbooking::admin.heat-map.google')
@elseif($settings['location']['map_provider'] == 'osm')
    @includeIf('cabbooking::admin.heat-map.osm')
@endif
