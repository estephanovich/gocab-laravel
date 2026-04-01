@use('Illuminate\Support\Arr')
@php
    $ridestatuscolorClasses = getRideStatusColorClasses();
    $dateRange = getStartAndEndDate(request('sort'), request('start'), request('end'));
    $start_date = $dateRange['start'] ?? null;
    $end_date = $dateRange['end'] ?? null;
    $serviceCategories = getAllServices();
@endphp


{{-- Recent Rides --}}
@can('ride.index')
    <div class="col-xxl-5 col-xl-6">
        <div class="card top-drivers-card p-0">
            <div class="card-header">
               <h3>{{ __('cabbooking::static.widget.recent_rides') }}</h3>
               <a href="{{ route('admin.ride.index') }}">{{ __('cabbooking::static.widget.view_all') }}</a>
           </div>
           <div class="rides-tab analytics-section">
               <ul class="nav nav-tabs horizontal-tab custom-scroll" id="ride-tabs" role="tablist">
                   @forelse ($serviceCategories as $key => $serviceCategory)
                       <li class="nav-item" role="presentation">
                           <a class="nav-link @if ($key === 0) active @endif"
                               id="tab-{{ $serviceCategory->id }}-tab" data-bs-toggle="tab"
                               href="#tab-{{ $serviceCategory->id }}" role="tab"
                               aria-controls="tab-{{ $serviceCategory->id }}"
                               aria-selected="{{ $key === 0 ? 'true' : 'false' }}">
                               {{ $serviceCategory->name }}
                           </a>
                       </li>
                   @empty
                       <li class="nav-item" role="presentation">
                           <a class="nav-link disabled" href="#" role="tab" aria-disabled="true">
                               {{ __('cabbooking::static.widget.no_categories_available') }}
                           </a>
                       </li>
                   @endforelse
               </ul>
           </div>
            <div class="recent-rides-card custom-scrollbar">

                <div class="card-body top-drivers recent-rides p-0 " >
                    <div class="tab-content">

                        @forelse ($serviceCategories as $key => $serviceCategory)

                            <div class="tab-pane fade @if ($key === 0) show active @endif"
                                id="tab-{{ $serviceCategory->id }}" role="tabpanel"
                                aria-labelledby="tab-{{ $serviceCategory->id }}-tab">

                                @php
                                    $categoryRides = getRecentRides($start_date, $end_date, $serviceCategory?->id);
                                @endphp
                                @if(count($categoryRides))
                                <table class="recent-rides-table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('cabbooking::static.widget.ride_id') }}</th>
                                            <th>{{ __('cabbooking::static.widget.driver_name') }}</th>
                                            <th>{{ __('cabbooking::static.widget.distance') }}</th>
                                            <th>{{ __('cabbooking::static.widget.status') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($categoryRides as $ride)
                                            @if ($ride?->driver && $ride)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('admin.ride.details', $ride?->id) }}">
                                                            <span class="id-wrapper">#{{ $ride?->ride_number ?? 'N/A' }}</span>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <div class="driver-info">
                                                            @if ($ride?->driver?->profile_image?->original_url)
                                                            <img src="{{ $ride?->driver?->profile_image?->original_url }}" alt="">
                                                            @else
                                                                <div class="initial-letter">
                                                                    <span>{{ strtoupper($ride?->driver?->name[0]) }}</span>
                                                                </div>
                                                            @endif
                                                            <div>
                                                                <h4>{{ $ride?->driver?->name ?? 'N/A' }}</h4>
                                                                <span>@if(isDemoModeEnabled())
                                                                    {{ __('cabbooking::static.demo_mode') }}
                                                                @else
                                                                    {{ $ride?->driver?->email }}
                                                                @endif
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $ride?->distance ?? 0 }} {{ ucfirst($ride?->distance_unit ?? 'N/A') }} </td>
                                                    <td>
                                                        @if($ride?->ride_status)
                                                        <span class="status {{ $ride?->ride_status?->slug }}">{{ $ride?->ride_status?->name }}</span>
                                                        @else
                                                        <span class="status secondary">N/A</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @empty

                                        @endforelse
                                    </tbody>
                                </table>
                                @else
                                 <div class="table-no-data">
                                                    <img src="{{ asset('images/dashboard/data-not-found.svg') }}"
                                                        alt="data not found" />
                                                    <h6 class="text-center">
                                                        {{ __('cabbooking::static.widget.no_data_available') }}</h6>
                                                </div>
                                @endif
                            </div>
                        @empty
                            <div>N/A</div>
                        @endempty
                    </div>
                </div>
            </div>

    </div>
</div>
@endcan
