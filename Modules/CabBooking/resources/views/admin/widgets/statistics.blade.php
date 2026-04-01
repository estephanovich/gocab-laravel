@use('Modules\CabBooking\Models\WithdrawRequest')
@use('Modules\CabBooking\Models\DriverWallet')
@use('Modules\CabBooking\Enums\RideStatusEnum')
@use('Modules\CabBooking\Models\Driver')
@use('App\Enums\RoleEnum')
@use('Modules\CabBooking\Enums\RoleEnum as CabBookingRoleEnum')
@php
    $roleName = getCurrentRoleName();
    if (getCurrentRoleName() == CabBookingRoleEnum::DRIVER) {
        $driver = Driver::where('id', getCurrentUserId())->first();
    }
    $dateRange = getStartAndEndDate(request('sort'), request('start'), request('end'));
    $start_date = $dateRange['start'] ?? null;
    $end_date = $dateRange['end'] ?? null;
    $services = getAllServices();
@endphp

<div class="col-12">
    <div class="row">
        @can('ride.index')
        <div class="col-xxl-4">
            <div class="row">
                <div class="col-xxl-12 col-xl-6">
                    <div class="card welcome-card">
                        <div class="card-body welcome-card-body">
                            <div class="wlc-card-wrap">
                                <div class="text-aligns">
                                    <h3>
                                        {{ auth()?->user()?->name ?? getCurrentRoleName() }}
                                        <img src="{{ asset('images/dashboard/hand.gif') }}" alt="">
                                    </h3>
                                    <p>
                                        {{ __('cabbooking::static.front_info') }}
                                    </p>
                                </div>
                                <button class="btn btn-light">
                                    <a href="{{ route('admin.ride-request.create') }}">
                                        {{ __('cabbooking::front.book_now') }}
                                    </a>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-12 col-xl-6">
                    <div class="row">
                        <div class="col-sm-6">
                           <a href="{{ route('admin.ride.status.filter', ['status' => RideStatusEnum::REQUESTED]) }}">
                                <div class="card widgets">
                                    <div class="card-body p-0">
                                        <div class="widget-wrapper">
                                            <div class="svg-wrapper">
                                                <svg>
                                                    <use
                                                        xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#request-ride') }}">
                                                    </use>
                                                </svg>
                                            </div>
                                            <div class="content-wrapper">
                                                <h3>{{ getTotalRidesByStatus(RideStatusEnum::REQUESTED, $start_date, $end_date) ?? 0 }}
                                                </h3>
                                                <p>{{ __('cabbooking::static.rides.requested') }}</p>
                                            </div>
                                            <svg class="redirecting">
                                                <use
                                                    xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#arrow-right') }}">
                                                </use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6">

                            <a href="{{ route('admin.ride.status.filter', ['status' => RideStatusEnum::ACCEPTED]) }}">
                                <div class="card widgets">
                                    <div class="card-body p-0">
                                        <div class="widget-wrapper">
                                            <div class="svg-wrapper">
                                                <svg>
                                                    <use
                                                        xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#accept-ride') }}">
                                                    </use>
                                                </svg>
                                            </div>
                                            <div class="content-wrapper">
                                                <h3>{{ getTotalRidesByStatus(RideStatusEnum::ACCEPTED, $start_date, $end_date) ?? 0 }}
                                                </h3>
                                                <p> {{ __('cabbooking::static.rides.accepted') }}</p>
                                            </div>
                                            <svg class="redirecting">
                                                <use
                                                    xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#arrow-right') }}">
                                                </use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('admin.ride.status.filter', ['status' => RideStatusEnum::STARTED]) }}">
                                <div class="card widgets">
                                    <div class="card-body p-0">
                                        <div class="widget-wrapper">
                                            <div class="svg-wrapper">
                                                <svg>
                                                    <use
                                                        xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#started-ride') }}">
                                                    </use>
                                                </svg>
                                            </div>
                                            <div class="content-wrapper">
                                                <h3>{{ getTotalRidesByStatus(RideStatusEnum::STARTED, $start_date, $end_date) ?? 0 }}
                                                </h3>
                                                <p>{{ __('cabbooking::static.rides.started') }}</p>
                                            </div>
                                            <svg class="redirecting">
                                                <use
                                                    xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#arrow-right') }}">
                                                </use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('admin.ride.status.filter', ['status' => RideStatusEnum::SCHEDULED]) }}">
                                <div class="card widgets">
                                    <div class="card-body p-0">
                                        <div class="widget-wrapper">
                                            <div class="svg-wrapper">
                                                <svg>
                                                    <use
                                                        xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#scheduled-ride') }}">
                                                    </use>
                                                </svg>
                                            </div>
                                            <div class="content-wrapper">
                                                <h3>{{ getTotalRidesByStatus(RideStatusEnum::SCHEDULED, $start_date, $end_date) ?? 0 }}
                                                </h3>
                                                <p>{{ __('cabbooking::static.rides.scheduled') }}</p>
                                            </div>
                                            <svg class="redirecting">
                                                <use
                                                    xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#arrow-right') }}">
                                                </use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('admin.ride.status.filter', ['status' => RideStatusEnum::CANCELLED]) }}">
                                <div class="card widgets">
                                    <div class="card-body p-0">
                                        <div class="widget-wrapper">
                                            <div class="svg-wrapper">
                                                <svg>
                                                    <use
                                                        xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#cancelled-ride') }}">
                                                    </use>
                                                </svg>
                                            </div>
                                            <div class="content-wrapper">
                                                <h3>{{ getTotalRidesByStatus(RideStatusEnum::CANCELLED, $start_date, $end_date) ?? 0 }}
                                                </h3>
                                                <p>{{ __('cabbooking::static.rides.cancelled') }}</p>
                                            </div>
                                            <svg class="redirecting">
                                                <use
                                                    xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#arrow-right') }}">
                                                </use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('admin.ride.status.filter', ['status' => RideStatusEnum::COMPLETED]) }}">
                                <div class="card widgets">
                                    <div class="card-body p-0">
                                        <div class="widget-wrapper">
                                            <div class="svg-wrapper">
                                                <svg>
                                                    <use
                                                        xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#completed-ride') }}">
                                                    </use>
                                                </svg>
                                            </div>
                                            <div class="content-wrapper">
                                                <h3>{{ getTotalRidesByStatus(RideStatusEnum::COMPLETED, $start_date, $end_date) ?? 0 }}
                                                </h3>
                                                <p>{{ __('cabbooking::static.rides.completed') }}</p>
                                            </div>
                                            <svg class="redirecting">
                                                <use
                                                    xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#arrow-right') }}">
                                                </use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endcan
        @can('driver.index')
            <div class="col-xxl-8">
                <div class="row dashboard-default-row">
                    @if ($roleName != CabBookingRoleEnum::DRIVER)
                        <div class="col-xxl-3 col-xl-3 col-md-4 col-sm-6">
                            <a href="{{ route('admin.driver.index') }}">
                                <div class="card widgets widgets2">
                                    <div class="card-body p-0">
                                        <div class="widget-content">
                                            <div class="widget-wrapper">
                                                <div class="svg-wrapper">
                                                    <svg>
                                                        <use
                                                            xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#verified-drivers') }}">
                                                        </use>
                                                    </svg>
                                                </div>
                                                <div class="content-wrapper">
                                                    <h3>{{ getTotalDrivers($start_date, $end_date, true) }}</h3>

                                                </div>
                                            </div>
                                            <div class="bottom-content">
                                                <h4>{{ __('cabbooking::static.widget.total_verified_drivers') }}</h4>
                                                <div class="numbers-wrapper">
                                                    @php
                                                        $verifiedDriversPercentage = getTotalDriversPercentage($start_date, $end_date, true);
                                                    @endphp
                                                    <span class="{{ $verifiedDriversPercentage['status'] == 'decrease' ? 'decreasing' : 'increasing' }}">
                                                        <svg>
                                                            <use
                                                                xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#' . ($verifiedDriversPercentage['status'] == 'decrease' ? 'decrease' : 'increase')) }}">
                                                            </use>
                                                        </svg>
                                                        {{ $verifiedDriversPercentage['status'] == 'decrease' ? '-' : '+' }}
                                                        {{ $verifiedDriversPercentage['percentage'] }}%
                                                    </span>
                                                    <p data-bs-toggle="tooltip" data-bs-title=" {{ __('cabbooking::static.widget.widget_description') }}">
                                                        {{ __('cabbooking::static.widget.widget_description') }}
                                                    </p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xxl-3 col-xl-3 col-md-4 col-sm-6">
                            <a href="{{ route('admin.driver.unverified-drivers') }}">
                                <div class="card widgets widgets2">
                                    <div class="card-body p-0">
                                        <div class="widget-content">
                                            <div class="widget-wrapper">
                                                <div class="svg-wrapper">
                                                    <svg>
                                                        <use
                                                            xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#unverified-drivers') }}">
                                                        </use>
                                                    </svg>
                                                </div>
                                                <div class="content-wrapper">
                                                    <h3>{{ getTotalDrivers($start_date, $end_date, false) }}</h3>
                                                </div>
                                            </div>
                                            <div class="bottom-content">
                                                <h4>{{ __('cabbooking::static.widget.total_unverified_drivers') }}</h4>
                                                <div class="numbers-wrapper">
                                                    @php
                                                        $unverifiedDriversPercentage = getTotalDriversPercentage($start_date, $end_date, false);
                                                    @endphp
                                                    <span class="{{ $unverifiedDriversPercentage['status'] == 'decrease' ? 'decreasing' : 'increasing' }}">
                                                        <svg>
                                                            <use
                                                                xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#' . ($unverifiedDriversPercentage['status'] == 'decrease' ? 'decrease' : 'increase')) }}">
                                                            </use>
                                                        </svg>
                                                        {{ $unverifiedDriversPercentage['status'] == 'decrease' ? '-' : '+' }}
                                                        {{ $unverifiedDriversPercentage['percentage'] }}%
                                                    </span>
                                                    <p data-bs-toggle="tooltip" data-bs-title=" {{ __('cabbooking::static.widget.widget_description') }}">
                                                        {{ __('cabbooking::static.widget.widget_description') }}
                                                    </p>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif

                    @can('rider.index')
                        <div class="col-xxl-3 col-xl-3 col-md-4 col-sm-6">
                            <a href="{{ route('admin.rider.index') }}">
                                <div class="card widgets widgets2">
                                    <div class="card-body p-0">
                                        <div class="widget-content">
                                            <div class="widget-wrapper">
                                                <div class="svg-wrapper">
                                                    <svg>
                                                        <use
                                                            xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#total-riders') }}">
                                                        </use>
                                                    </svg>
                                                </div>
                                                <div class="content-wrapper">
                                                    <h3>{{ getTotalRiders($start_date, $end_date) }}</h3>
                                                </div>
                                            </div>
                                            <div class="bottom-content">
                                                <h4>{{ __('cabbooking::static.widget.total_riders') }}</h4>
                                                <div class="numbers-wrapper">
                                                    @php
                                                        $ridersPercentage = getTotalRidersPercentage($start_date, $end_date);
                                                    @endphp
                                                    <span class="{{ $ridersPercentage['status'] == 'decrease' ? 'decreasing' : 'increasing' }}">
                                                        <svg>
                                                            <use
                                                                xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#' . ($ridersPercentage['status'] == 'decrease' ? 'decrease' : 'increase')) }}">
                                                            </use>
                                                        </svg>
                                                        {{ $ridersPercentage['status'] == 'decrease' ? '-' : '+' }}
                                                        {{ $ridersPercentage['percentage'] }}%
                                                    </span>
                                                    <p data-bs-toggle="tooltip" data-bs-title=" {{ __('cabbooking::static.widget.widget_description') }}">
                                                        {{ __('cabbooking::static.widget.widget_description') }}
                                                    </p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endcan

                    @can('ride.index')
                        <div class="col-xxl-3 col-xl-3 col-md-4 col-sm-6">
                            <a href="{{ route('admin.ride.index') }}">
                                <div class="card widgets widgets2">
                                    <div class="card-body p-0">
                                        <div class="widget-content">
                                            <div class="widget-wrapper">
                                                <div class="svg-wrapper">
                                                    <svg>
                                                        <use
                                                            xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#total-rides') }}">
                                                        </use>
                                                    </svg>
                                                </div>
                                                <div class="content-wrapper">
                                                    <h3>{{ getTotalRides($start_date, $end_date) }}</h3>
                                                </div>
                                            </div>
                                            <div class="bottom-content">
                                                <h4>{{ __('cabbooking::static.widget.total_rides') }}</h4>
                                                <div class="numbers-wrapper">
                                                    @php
                                                        $ridesPercentage = getTotalRidesPercentage($start_date, $end_date);
                                                    @endphp
                                                    <span class="{{ $ridesPercentage['status'] == 'decrease' ? 'decreasing' : 'increasing' }}">
                                                        <svg>
                                                            <use
                                                                xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#' . ($ridesPercentage['status'] == 'decrease' ? 'decrease' : 'increase')) }}">
                                                            </use>
                                                        </svg>
                                                        {{ $ridesPercentage['status'] == 'decrease' ? '-' : '+' }}
                                                        {{ $ridesPercentage['percentage'] }}%
                                                    </span>
                                                    <p data-bs-toggle="tooltip" data-bs-title=" {{ __('cabbooking::static.widget.widget_description') }}">
                                                        {{ __('cabbooking::static.widget.widget_description') }}
                                                    </p>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </a>
                        </div>
                    @endcan

                    {{-- Total Revenue --}}
                    <div class="col-xxl-3 col-xl-3 col-md-4 col-sm-6">
                        <div class="card widgets widgets2">
                            <div class="card-body p-0">
                                <div class="widget-content">
                                    <div class="widget-wrapper">
                                        <div class="svg-wrapper">
                                            <svg>
                                                <use
                                                    xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#total-revenue') }}">
                                                </use>
                                            </svg>
                                        </div>
                                        <div class="content-wrapper">
                                            <h3>{{ formatCurrency(getTotalRidesEarnings($start_date, $end_date)) }}
                                            </h3>

                                        </div>
                                    </div>
                                    <div class="bottom-content">
                                        <h4>{{ __('cabbooking::static.widget.total_revenue') }}</h4>
                                        <div class="numbers-wrapper">
                                                @php
                                                    $revenuePercentage = getTotalRidesEarningsPercentage($start_date, $end_date);
                                                @endphp
                                                <span class="{{ $revenuePercentage['status'] == 'decrease' ? 'decreasing' : 'increasing' }}">
                                                    <svg>
                                                        <use
                                                            xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#' . ($revenuePercentage['status'] == 'decrease' ? 'decrease' : 'increase')) }}">
                                                        </use>
                                                    </svg>
                                                    {{ $revenuePercentage['status'] == 'decrease' ? '-' : '+' }}
                                                    {{ $revenuePercentage['percentage'] }}%
                                                </span>
                                            <p data-bs-toggle="tooltip" data-bs-title=" {{ __('cabbooking::static.widget.widget_description') }}">
                                                {{ __('cabbooking::static.widget.widget_description') }}
                                            </p>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Offline Payment --}}
                    <div class="col-xxl-3 col-xl-3 col-md-4 col-sm-6">
                        <div class="card widgets widgets2">
                            <div class="card-body p-0">
                                <div class="widget-content">
                                    <div class="widget-wrapper">
                                        <div class="svg-wrapper">
                                            <svg>
                                                <use
                                                    xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#offline-payment') }}">
                                                </use>
                                            </svg>
                                        </div>
                                        <div class="content-wrapper">
                                            <h3> {{ formatCurrency(getTotalRidesEarnings($start_date, $end_date, 'online')) }}
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="bottom-content">
                                        <h4>{{ __('cabbooking::static.widget.offline_payment') }}</h4>
                                        <div class="numbers-wrapper">
                                                @php
                                                    $offlinePaymentPercentage = getTotalRidesEarningsPercentage($start_date, $end_date, 'cash');
                                                @endphp
                                                <span class="{{ $offlinePaymentPercentage['status'] == 'decrease' ? 'decreasing' : 'increasing' }}">
                                                    <svg>
                                                        <use
                                                            xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#' . ($offlinePaymentPercentage['status'] == 'decrease' ? 'decrease' : 'increase')) }}">
                                                        </use>
                                                    </svg>
                                                    {{ $offlinePaymentPercentage['status'] == 'decrease' ? '-' : '+' }}
                                                    {{ $offlinePaymentPercentage['percentage'] }}%
                                                </span>
                                            <p data-bs-toggle="tooltip" data-bs-title=" {{ __('cabbooking::static.widget.widget_description') }}">
                                                {{ __('cabbooking::static.widget.widget_description') }}
                                            </p>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Online Payment --}}
                    <div class="col-xxl-3 col-xl-3 col-md-4 col-sm-6">
                        <div class="card widgets widgets2">
                            <div class="card-body p-0">
                                <div class="widget-content">
                                    <div class="widget-wrapper">
                                        <div class="svg-wrapper">
                                            <svg>
                                                <use
                                                    xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#online-payment') }}">
                                                </use>
                                            </svg>
                                        </div>
                                        <div class="content-wrapper">
                                            <h3> {{ formatCurrency(getTotalRidesEarnings($start_date, $end_date, 'online')) }}
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="bottom-content">
                                        <h4>{{ __('cabbooking::static.widget.online_payment') }}</h4>
                                        <div class="numbers-wrapper">
                                                @php
                                                    $onlinePaymentPercentage = getTotalRidesEarningsPercentage($start_date, $end_date, 'online');
                                                @endphp
                                                <span class="{{ $onlinePaymentPercentage['status'] == 'decrease' ? 'decreasing' : 'increasing' }}">
                                                    <svg>
                                                        <use
                                                            xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#' . ($onlinePaymentPercentage['status'] == 'decrease' ? 'decrease' : 'increase')) }}">
                                                        </use>
                                                    </svg>
                                                    {{ $onlinePaymentPercentage['status'] == 'decrease' ? '-' : '+' }}
                                                    {{ $onlinePaymentPercentage['percentage'] }}%
                                                </span>
                                            <p data-bs-toggle="tooltip" data-bs-title=" {{ __('cabbooking::static.widget.widget_description') }}">
                                                {{ __('cabbooking::static.widget.widget_description') }}
                                            </p>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                    @if ($roleName != CabBookingRoleEnum::DRIVER)
                        @can('withdraw_request.index')
                            <div class="col-xxl-3 col-xl-3 col-md-4 col-sm-6">
                                <a href="{{ route('admin.withdraw-request.index') }}">
                                    <div class="card widgets widgets2">
                                        <div class="card-body p-0">
                                            <div class="widget-content">
                                                <div class="widget-wrapper">
                                                    <div class="svg-wrapper">
                                                        <svg>
                                                            <use
                                                                xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#withdraw-request') }}">
                                                            </use>
                                                        </svg>
                                                    </div>
                                                    <div class="content-wrapper">
                                                        <h3>{{ formatCurrency(getTotalWithdrawals($start_date, $end_date)) }}
                                                        </h3>
                                                    </div>
                                                </div>
                                                <div class="bottom-content">
                                                    <h4>{{ __('cabbooking::static.widget.withdraw_request') }}</h4>
                                                    <div class="numbers-wrapper">
                                                        @php
                                                            $withdrawRequestsPercentage = getTotalWithdrawRequestsPercentage($start_date, $end_date);
                                                        @endphp
                                                        <span class="{{ $withdrawRequestsPercentage['status'] == 'decrease' ? 'decreasing' : 'increasing' }}">
                                                            <svg>
                                                                <use
                                                                    xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#' . ($withdrawRequestsPercentage['status'] == 'decrease' ? 'decrease' : 'increase')) }}">
                                                                </use>
                                                            </svg>
                                                            {{ $withdrawRequestsPercentage['status'] == 'decrease' ? '-' : '+' }}
                                                            {{ $withdrawRequestsPercentage['percentage'] }}%
                                                        </span>
                                                        <p data-bs-toggle="tooltip" data-bs-title=" {{ __('cabbooking::static.widget.widget_description') }}">
                                                            {{ __('cabbooking::static.widget.widget_description') }}
                                                        </p>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endcan
                    @endif

                    @can('fleet-manager.index')
                        @if ($roleName != CabBookingRoleEnum::FLEET_MANAGER && $roleName != CabBookingRoleEnum::DRIVER)
                            <div class="col-xxl-3 col-xl-3 col-md-4 col-sm-6">

                                <a href="{{ route('admin.fleet-manager.index') }}">
                                    <div class="card widgets widgets2">
                                        <div class="card-body p-0">
                                            <div class="widget-content">
                                                <div class="widget-wrapper">
                                                    <div class="svg-wrapper">
                                                        <svg>
                                                            <use
                                                                xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#fleet-manager') }}">
                                                            </use>
                                                        </svg>
                                                    </div>
                                                    <div class="content-wrapper">
                                                        <h3>{{ getTotalFleetManagers($start_date, $end_date) }}</h3>
                                                    </div>
                                                </div>
                                                <div class="bottom-content">
                                                    <h4>{{ __('cabbooking::static.widget.fleet_managers_info') }}</h4>
                                                    <div class="numbers-wrapper">
                                                        @php
                                                            $fleetManagersPercentage = getTotalFleetManagersPercentage($start_date, $end_date);
                                                        @endphp
                                                        <span class="{{ $fleetManagersPercentage['status'] == 'decrease' ? 'decreasing' : 'increasing' }}">
                                                            <svg>
                                                                <use
                                                                    xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#' . ($fleetManagersPercentage['status'] == 'decrease' ? 'decrease' : 'increase')) }}">
                                                                </use>
                                                            </svg>
                                                            {{ $fleetManagersPercentage['status'] == 'decrease' ? '-' : '+' }}
                                                            {{ $fleetManagersPercentage['percentage'] }}%
                                                        </span>
                                                        <p data-bs-toggle="tooltip" data-bs-title=" {{ __('cabbooking::static.widget.widget_description') }}">
                                                            {{ __('cabbooking::static.widget.widget_description') }}
                                                        </p>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @endcan

                    @can('driver.index')
                        @if ($roleName != CabBookingRoleEnum::DRIVER)
                            <div class="col-xxl-3 col-xl-3 col-md-4 col-sm-6">
                                <a href="{{ route('admin.vehicle-info.index') }}">
                                    <div class="card widgets widgets2">
                                        <div class="card-body p-0">
                                            <div class="widget-content">
                                                <div class="widget-wrapper">
                                                    <div class="svg-wrapper">
                                                        <svg>
                                                            <use
                                                                xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#fleet-vehicles') }}">
                                                            </use>
                                                        </svg>
                                                    </div>
                                                    <div class="content-wrapper">
                                                        <h3>{{ getFleetVehicles($start_date, $end_date, true) }}</h3>
                                                    </div>
                                                </div>
                                                <div class="bottom-content">
                                                    <h4>{{ __('cabbooking::static.widget.fleet_vehicle_type') }}</h4>
                                                    <div class="numbers-wrapper">
                                                        @php
                                                            $fleetVehiclesPercentage = getFleetVehiclesPercentage($start_date, $end_date, true);
                                                        @endphp
                                                        <span class="{{ $fleetVehiclesPercentage['status'] == 'decrease' ? 'decreasing' : 'increasing' }}">
                                                            <svg>
                                                                <use
                                                                    xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#' . ($fleetVehiclesPercentage['status'] == 'decrease' ? 'decrease' : 'increase')) }}">
                                                                </use>
                                                            </svg>
                                                            {{ $fleetVehiclesPercentage['status'] == 'decrease' ? '-' : '+' }}
                                                            {{ $fleetVehiclesPercentage['percentage'] }}%
                                                        </span>
                                                        <p data-bs-toggle="tooltip" data-bs-title=" {{ __('cabbooking::static.widget.widget_description') }}">
                                                            {{ __('cabbooking::static.widget.widget_description') }}
                                                        </p>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @endcan

                    @can('dispatcher.index')
                        @if ($roleName != CabBookingRoleEnum::DISPATCHER)
                            <div class="col-xxl-3 col-xl-3 col-md-4 col-sm-6">
                                <a href="{{ route('admin.dispatcher.index') }}">

                                    <div class="card widgets widgets2">
                                        <div class="card-body p-0">
                                            <div class="widget-content">
                                                <div class="widget-wrapper">
                                                    <div class="svg-wrapper">
                                                        <svg>
                                                            <use
                                                                xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#dispatcher') }}">
                                                            </use>
                                                        </svg>
                                                    </div>
                                                    <div class="content-wrapper">
                                                        <h3>{{ getTotalDispatchers($start_date, $end_date, false) }}</h3>
                                                    </div>
                                                </div>
                                                <div class="bottom-content">
                                                    <h4>{{ __('cabbooking::static.widget.dispatcher') }}</h4>
                                                    <div class="numbers-wrapper">
                                                        @php
                                                            $dispatchersPercentage = getTotalDispatchersPercentage($start_date, $end_date);
                                                        @endphp
                                                        <span class="{{ $dispatchersPercentage['status'] == 'decrease' ? 'decreasing' : 'increasing' }}">
                                                            <svg>
                                                                <use
                                                                    xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#' . ($dispatchersPercentage['status'] == 'decrease' ? 'decrease' : 'increase')) }}">
                                                                </use>
                                                            </svg>
                                                            {{ $dispatchersPercentage['status'] == 'decrease' ? '-' : '+' }}
                                                            {{ $dispatchersPercentage['percentage'] }}%
                                                        </span>
                                                        <p data-bs-toggle="tooltip" data-bs-title=" {{ __('cabbooking::static.widget.widget_description') }}">
                                                            {{ __('cabbooking::static.widget.widget_description') }}
                                                        </p>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @endcan

                    @if ($roleName == CabBookingRoleEnum::FLEET_MANAGER)
                        @can('fleet_wallet.index')
                            <div class="col-xxl-3 col-xl-3 col-md-4 col-sm-6">
                                <div class="card widgets widgets2">
                                    <div class="card-body p-0">
                                        <div class="widget-content">
                                            <div class="widget-wrapper">
                                                <div class="svg-wrapper">
                                                    <svg>
                                                        <use
                                                            xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#dispatcher') }}">
                                                        </use>
                                                    </svg>
                                                </div>
                                                <div class="content-wrapper">
                                                    <h3> {{ getDefaultCurrency()?->symbol }}{{ number_format(getFleetWalletBalance(getCurrentUserId(), $start_date, $end_date), 2) }}
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="bottom-content">
                                                <h4>{{ __('cabbooking::static.widget.Wallet_balance') }}</h4>
                                                <div class="numbers-wrapper">
                                                    @php
                                                        $walletsPercentage = getTotalWalletsPercentage($start_date, $end_date);
                                                    @endphp
                                                    <span class="{{ $walletsPercentage['status'] == 'decrease' ? 'decreasing' : 'increasing' }}">
                                                        <svg>
                                                            <use
                                                                xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#' . ($walletsPercentage['status'] == 'decrease' ? 'decrease' : 'increase')) }}">
                                                            </use>
                                                        </svg>
                                                        {{ $walletsPercentage['status'] == 'decrease' ? '-' : '+' }}
                                                        {{ $walletsPercentage['percentage'] }}%
                                                    </span>
                                                    <p data-bs-toggle="tooltip" data-bs-title=" {{ __('cabbooking::static.widget.widget_description') }}">
                                                        {{ __('cabbooking::static.widget.widget_description') }}
                                                    </p>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endcan
                    @endif

                    <div class="col-xxl-3 col-xl-3 col-md-4 col-sm-6">
                        <a href="{{ route('admin.peakZone.index') }}">
                            <div class="card widgets widgets2">
                                <div class="card-body p-0">
                                    <div class="widget-content">
                                        <div class="widget-wrapper">
                                            <div class="svg-wrapper">
                                                <svg>
                                                    <use
                                                        xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#peak-zone') }}">
                                                    </use>
                                                </svg>
                                            </div>
                                            <div class="content-wrapper">
                                                <h3>{{ getPeakZones($start_date, $end_date) }}</h3>
                                            </div>
                                        </div>
                                        <div class="bottom-content">
                                            <h4>{{ __('cabbooking::static.widget.peak_zone') }}</h4>
                                            <div class="numbers-wrapper">
                                                    @php
                                                        $peakZonesPercentage = getPeakZonesPercentage($start_date, $end_date);
                                                    @endphp
                                                    <span class="{{ $peakZonesPercentage['status'] == 'decrease' ? 'decreasing' : 'increasing' }}">
                                                        <svg>
                                                            <use
                                                                xlink:href="{{ asset('images/dashboard/details/icon-sprite.svg#' . ($peakZonesPercentage['status'] == 'decrease' ? 'decrease' : 'increase')) }}">
                                                            </use>
                                                        </svg>
                                                        {{ $peakZonesPercentage['status'] == 'decrease' ? '-' : '+' }}
                                                        {{ $peakZonesPercentage['percentage'] }}%
                                                    </span>
                                                <p data-bs-toggle="tooltip" data-bs-title=" {{ __('cabbooking::static.widget.widget_description') }}" >
                                                {{ __('cabbooking::static.widget.widget_description') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        @endcan
    </div>
</div>
