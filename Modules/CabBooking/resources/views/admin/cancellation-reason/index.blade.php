@extends('admin.layouts.master')
@section('title', __('cabbooking::static.cancellation-reasons.cancellation-reasons'))
@section('content')
    <div class="contentbox">
        <div class="inside">
            <div class="contentbox-title">
                <div class="contentbox-subtitle">
                    <h3>{{ __('cabbooking::static.cancellation-reasons.cancellation-reasons') }}</h3>
                    <div class="subtitle-button-group">
                        @can('cancellation_reason.create')
                            <button class="add-spinner btn btn-outline"
                                data-url="{{ route('admin.cancellation-reason.create') }}">
                                <i class="ri-add-line"></i> {{ __('cabbooking::static.cancellation-reasons.add_new') }}
                            </button>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="cancellationReason-table">
                <x-table :columns="$tableConfig['columns']" 
                :data="$tableConfig['data']" 
                :filters="$tableConfig['filters']" 
                :actions="$tableConfig['actions']" 
                :total="$tableConfig['total']"
                :bulkactions="$tableConfig['bulkactions']" 
                :search="true" />
            </div>
        </div>
    </div>
@endsection
