@php
    $settings = getCabBookingSettings();
@endphp
@extends('admin.layouts.master')
@section('title', __('cabbooking::static.peakZones.map_view'))
@section('content')
    <div class="map-section">
        <div class="contentbox">
            <div class="inside">
                <div class="contentbox-title">
                    <div class="contentbox-subtitle">
                        <h3>{{ __('cabbooking::static.peakZones.map_view') }}</h3>
                    </div>
                    <div class="contentbox-right">
                        <select class="form-select" id="zone-filter">
                            <option value="all">{{ __('cabbooking::static.all') }}</option>
                            <option value="active">{{ __('cabbooking::static.active') }}</option>
                            <option value="inactive">{{ __('cabbooking::static.inactive') }}</option>
                        </select>
                    </div>
                </div>
                <div class="map-box">
                    <div id="map" style="height: 600px;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@if ($settings['location']['map_provider'] == 'google_map')
    @includeIf('cabbooking::admin.peak-zone-map.google')
@elseif($settings['location']['map_provider'] == 'osm')
    @includeIf('cabbooking::admin.peak-zone-map.osm')
@endif
