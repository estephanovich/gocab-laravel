@extends('admin.layouts.master')
@section('title', __('cabbooking::static.soses.sos'))
@section('content')
    <div class="contentbox">
        <div class="inside">
            <div class="contentbox-title">
                <div class="contentbox-subtitle">
                    <h3>{{ __('cabbooking::static.soses.sos') }}</h3>
                    <div class="subtitle-button-group">
                        @can('sos.create')
                            <button class="add-spinner btn btn-outline" data-url="{{ route('admin.sos.create') }}">
                                <i class="ri-add-line"></i> {{ __('cabbooking::static.soses.add_new') }}
                            </button>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="sos-table">
                <x-table :columns="$tableConfig['columns']" 
                         :data="$tableConfig['data']" 
                         :filters="$tableConfig['filters']" 
                         :actions="$tableConfig['actions']" 
                         :total="$tableConfig['total']"
                         :bulkactions="$tableConfig['bulkactions']" 
                         :search="true">
                </x-table>
            </div>
        </div>
    </div>
@endsection
