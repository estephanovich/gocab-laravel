@extends('admin.layouts.master')
@section('title', __('cabbooking::static.vehicle_types.vehicles'))
@section('content')
@includeIf('inc.modal', [
        'export' => true,
        'routes' => 'admin.user.export',
        'import' => true,
        'route' => 'admin.user.import.csv',
        'instruction_file' => 'admin/import/users',
        'example_file' => 'admin/import/example/users.csv',
    ])
    <div class="contentbox">
        <div class="inside">
            <div class="contentbox-title">
                <div class="contentbox-subtitle">
                    <h3>{{ __('cabbooking::static.vehicle_types.vehicles') }}</h3>
                    <div class="subtitle-button-group">
                        @can('vehicle_type.create')
                            <button class="add-spinner btn btn-outline" data-url="{{ getVehicleCreateRoute() }}">
                                <i class="ri-add-line"></i> {{ __('cabbooking::static.vehicle_types.add_new') }}
                            </button>
                        @endcan
                        @can('vehicle_type.index')
                        @if($tableConfig['total'] > 0)
                            <button class="btn btn-outline" data-bs-toggle="modal" data-bs-target="#exportModal">
                                <i class="ri-download-line"></i>{{ __('static.export.export') }}
                            </button>
                        @endif
                        @endcan
                        @can('vehicle_type.create')
                            <button class="btn btn-outline" data-bs-toggle="modal" data-bs-target="#importModal"
                                id="importButton" data-model="user">
                                <i class="ri-upload-line"></i>{{ __('static.import.import') }}
                            </button>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="vehicle-table">
                <x-table :columns="$tableConfig['columns']" 
                         :data="$tableConfig['data']" 
                         :filters="$tableConfig['filters']" 
                         :actions="$tableConfig['actions']" 
                         :total="$tableConfig['total']"
                         :bulkactions="$tableConfig['bulkactions']" 
                         :actionButtons="$tableConfig['actionButtons']" 
                         :search="true">
                </x-table>
            </div>
        </div>
    </div>
@endsection
