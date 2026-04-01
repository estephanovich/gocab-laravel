@use('Modules\CabBooking\Enums\RoleEnum')
@php
$dateRange = getStartAndEndDate(request('sort'), request('start'), request('end'));
$start_date = $dateRange['start'] ?? null;
$end_date = $dateRange['end'] ?? null;
$roleName = getCurrentRoleName();
@endphp

{{-- Top Drivers --}}
@if($roleName != RoleEnum::DRIVER)
@can('driver.index')
<div class="col-xxl-4 col-xl-6">
    <div class="card top-drivers-card p-0">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">{{ __('cabbooking::static.widget.top_drivers') }}</h3>
            <a href="{{ route('admin.driver.index') }}" class="view-all">View All</a>
        </div>
        <div class="table-responsive custom-scrollbar">
            <table class="table top-drivers-table">
                <thead>
                    <tr>
                        <th>{{ __('cabbooking::static.driver_name') }}</th>
                        <th>{{ __('cabbooking::static.reports.ratings') }}</th>
                        <th>{{ __('cabbooking::static.drivers.total_rides') }}</th>
                        <th>{{ __('cabbooking::static.reports.earnings') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse (getTopDrivers($start_date,$end_date) as $driver)
                        @if($driver)
                            <tr>
                                <td>
                                    <div class="driver-info">
                                        @if ($driver?->profile_image?->original_url)
                                            <img src="{{ $driver?->profile_image?->original_url }}" alt="">
                                        @else
                                            <div class="initial-letter">
                                                <span>{{ strtoupper($driver->name[0]) }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <h6><a href="{{ route('admin.driver.show', ['driver' => $driver?->id]) }}">
                                                        {{ $driver?->name }}
                                                    </a></h6>
                                            <small> @if(isDemoModeEnabled())
                                                        {{ __('cabbooking::static.demo_mode') }}
                                                    @else
                                                        {{ $driver?->email }}
                                                    @endif
                                                </small>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="rating">
                                        <svg>
                                            <use xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#star') }}">
                                            </use>
                                        </svg>
                                        ({{ number_format($driver->rating_count, 1) }})
                                    </span>
                                </td>
                                <td>{{ getTotalDriverRides($driver?->id) }}</td>
                                <td>{{ formatCurrency(getDriverWallet($driver->id)) ?? 0 }}</td>
                            </tr>
                        @endif
                    @empty
                        <div class="table-no-data">
                            <img src="{{ asset('images/dashboard/data-not-found.svg') }}" class="img-fluid"
                                alt="data not found">
                            <h6 class="text-center">
                                {{ __('cabbooking::static.widget.no_data_available') }}
                            </h6>
                        </div>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endcan
@endif

