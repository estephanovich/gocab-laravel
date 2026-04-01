@use('Modules\CabBooking\Enums\ServicesEnum')
@use('Modules\CabBooking\Enums\ServiceCategoryEnum')
@php
    $cabRides = getTotalRidesByServices(ServicesEnum::CAB, request('start_date'), request('end_date'));
    $parcelRides = getTotalRidesByServices(ServicesEnum::PARCEL);
    $freightRides = getTotalRidesByServices(ServicesEnum::FREIGHT);
    $ambulanceRides = getTotalRidesByServices(ServicesEnum::AMBULANCE);
    $totalRides = getTotalRides();

    $dateRange = getStartAndEndDate(request('sort'), request('start'), request('end'));

    $start_date = $dateRange['start'] ?? null;
    $end_date = $dateRange['end'] ?? null;

    $intercityRides = getTotalRidesByServiceCategory(ServiceCategoryEnum::INTERCITY, $start_date, $end_date);
    $rideRides = getTotalRidesByServiceCategory(ServiceCategoryEnum::RIDE, $start_date, $end_date);
    $rentalRides = getTotalRidesByServiceCategory(ServiceCategoryEnum::RENTAL, $start_date, $end_date);
    $scheduledRides = getTotalRidesByServiceCategory(ServiceCategoryEnum::SCHEDULE, $start_date, $end_date);
    $packageRides = getTotalRidesByServiceCategory(ServiceCategoryEnum::PACKAGE, $start_date, $end_date);
    $totalRides = getTotalRides($start_date, $end_date);

    $services = [
        ServicesEnum::CAB => ['name' => 'Cab', 'categories' => [ServiceCategoryEnum::RIDE, ServiceCategoryEnum::INTERCITY, ServiceCategoryEnum::PACKAGE, ServiceCategoryEnum::SCHEDULE, ServiceCategoryEnum::RENTAL]],
        ServicesEnum::FREIGHT => ['name' => 'Freight', 'categories' => [ServiceCategoryEnum::RIDE, ServiceCategoryEnum::INTERCITY, ServiceCategoryEnum::SCHEDULE]],
        ServicesEnum::PARCEL => ['name' => 'Parcel', 'categories' => [ServiceCategoryEnum::RIDE, ServiceCategoryEnum::INTERCITY, ServiceCategoryEnum::SCHEDULE]],
        ServicesEnum::AMBULANCE => ['name' => 'Ambulance', 'categories' => []],
    ];
@endphp

{{-- Service --}}
@can('ride.index')
<div class="col-xxl-5 col-md-6">
    <div class="card service-chart">
        <div class="card-header p-0">
            <h3>
                {{ __('cabbooking::static.vehicle_types.services') }}
            </h3>
        </div>
        <div class="card-body p-0">
            <div id="service-chart"></div>
        </div>
    </div>
</div>

{{-- Service Categories --}}
<div class="col-xxl-3 col-md-6">
    <div class="card target-chart">
        <div class="card-header p-0">
            <h3>
                {{ __(__('cabbooking::static.widget.service_categories')) }}
            </h3>
            <select id="serviceSelector" class="form-select form-select-sm w-auto">
                @foreach ($services as $key => $service)
                    <option value="{{ $key }}">{{ $service['name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="card-body p-0">
            <div id="no-data" class="text-center d-none">
                <p> {{ __('cabbooking::static.widget.no_data_available') }}</p>
            </div>
            <div id="service-category-chart">
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('js/apex-chart.js') }}"></script>
    <script>
        var isDark = document.body.classList.contains("dark");

        var cab = <?php echo json_encode(array_values($cabRides)); ?>;
        var parcel = <?php echo json_encode(array_values($parcelRides)); ?>;
        var freight = <?php echo json_encode(array_values($freightRides)); ?>;
        var ambulance = <?php echo json_encode(array_values($ambulanceRides)); ?>;
        var totalRides = <?php echo $totalRides ?>;

        //service-chart
        var options = {
            chart: {
                type: 'bar',
                height: 350,
                stacked: true,
                toolbar: {
                    show: false
                }
            },

            tooltip: {
                theme: isDark ? "dark" : "light"
            },

            series: [{
                    name: "Cab",
                    data: cab
                },
                {
                    name: "Parcel",
                    data: parcel
                },
                {
                    name: "Freight",
                    data: freight
                },
                {
                    name: "Ambulance",
                    data: ambulance
                }
            ],

            colors: ["#AD8BFA", "#CBB5FD", "#E2D6FE", "#EFE9FE"],

            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%'
                }
            },

            dataLabels: {
                enabled: false
            },

            xaxis: {
                categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
            },

            yaxis: {
                min: 0,
                max: 800,
                tickAmount: 8,
                title: {
                    text: ''
                }
            },

            legend: {
                position: 'top',
                horizontalAlign: 'right',
                markers: {
                    shape: 'circle',
                    radius: 12
                }
            },

            grid: {
                borderColor: "#eee",
                strokeDashArray: 4
            },
            fill: {
                opacity: 0.85
            }
        };

        var chart = new ApexCharts(document.querySelector("#service-chart"), options);
        chart.render();

        // Service categories chart

        var isDark = document.body.classList.contains("dark");

const chartData = {
@foreach ($services as $serviceKey => $service)
    "{{ strtolower($serviceKey) }}": {
        labels: [
            @foreach ($service['categories'] as $cat)
                "{{ ucfirst(strtolower($cat->value ?? $cat)) }}",
            @endforeach
        ],
        values: [
            @foreach ($service['categories'] as $cat)
                {{ getTotalRidesByServiceCategory($cat, $start_date, $end_date) }},
            @endforeach
        ]
    },
@endforeach
};

let serviceCategoryChart;

function renderChart(serviceKey) {
    const data = chartData[serviceKey.toLowerCase()] ?? null;

    const hasData = data && data.values.length && data.values.some(v => v > 0);

    document.getElementById('no-data').classList.toggle('d-none', hasData);
    document.getElementById('service-category-chart').classList.toggle('d-none', !hasData);

    if (!hasData) {
        if (serviceCategoryChart) {
            serviceCategoryChart.destroy();
            serviceCategoryChart = null;
        }
        return;
    }

    const options = {
        series: data.values,
        labels: data.labels,

        chart: {
            type: 'polarArea',
            height: 300
        },

        stroke: {
            width: 2,
            colors: ['#fff']
        },

        fill: {
            opacity: 0.85
        },

        legend: {
            position: 'bottom',
            fontSize: '13px'
        },

        yaxis: {
            show: false
        },

        plotOptions: {
            polarArea: {
                rings: {
                    strokeColor: 'currentcolor'
                },
                spokes: {
                    strokeColor: 'currentcolor'
                }
            }
        },

        colors: [
            '#8B5CF6',
            '#FC776D',
            '#4CAF50',
            '#FFCA20',
            '#2196F3'
        ]
    };

    if (serviceCategoryChart) {
        serviceCategoryChart.destroy();
    }

    serviceCategoryChart = new ApexCharts(
        document.querySelector("#service-category-chart"),
        options
    );

    serviceCategoryChart.render();
}

document.addEventListener('DOMContentLoaded', function () {
    const selector = document.getElementById('serviceSelector');

    if (selector) {
        renderChart(selector.value);

        selector.addEventListener('change', function () {
            renderChart(this.value);
        });
    }
});


    </script>
@endpush
@endcan
