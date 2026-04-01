@extends('admin.layouts.master')
@section('title', __('cabbooking::static.peakZones.all'))
@section('content')
    <div class="contentbox">
        <div class="inside">
            <div class="contentbox-title">
                <div class="contentbox-subtitle">
                    <h3>{{ __('cabbooking::static.peakZones.all') }}</h3>
                </div>
            </div>
            <div class="peak-zone-table">
                <x-table :columns="$tableConfig['columns']"
                         :data="$tableConfig['data']"
                         :filters="$tableConfig['filters']"
                         :actions="$tableConfig['actions']"
                         :total="$tableConfig['total']"
                         :bulkactions="$tableConfig['bulkactions']" :search="true">
                </x-table>
            </div>
        </div>
    </div>
@endsection
