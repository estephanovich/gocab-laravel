@php
$commissions = getMonthlyCommissions();
$adminCommission = array_values($commissions['admin_commission'] ?? []);
$driverCommission = array_values($commissions['driver_commission'] ?? []);
$fleetCommission = array_values($commissions['fleet_commission'] ?? []);
@endphp
@can('ride.index')
{{-- Average Revenue --}}
    <div class="col-xxl-7">
        <div class="card revenue-chart p-0">
            <div class="card-header">
                <h3>
                   {{ __('cabbooking::static.widget.average_revenue') }}
                </h3>
            </div>
            <div class="card-body p-0">
                <div id="revenue-report">

                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script src="{{ asset('js/apex-chart.js') }}"></script>
    <script>
        // Convert PHP arrays to JavaScript using json_encode() with proper flags
        const adminCommission = @json($adminCommission ?? []);
        const driverCommission = @json($driverCommission ?? []);
        const fleetCommission = @json($fleetCommission ?? []);

        // Optional: Fallback to empty arrays of 12 zeros if data is missing/incomplete
        function padArray(arr, length = 12, fill = 0) {
            return arr.length >= length ? arr.slice(0, length) : [...arr, ...Array(length - arr.length).fill(fill)];
        }

        var revenueChart = {
            series: [
                {
                    name: "Fleet Commission",
                    type: "column",
                    data: padArray(fleetCommission)
                },
                {
                    name: "Admin Commission",
                    type: "line",
                    data: padArray(adminCommission)
                },
                {
                    name: "Driver Commission",
                    type: "line",
                    data: padArray(driverCommission)
                }
            ],

            chart: {
                height: 350,
                type: "line",
                toolbar: { show: false },
                stacked: false,
                dropShadow: {
                    enabled: true,
                    enabledOnSeries: [1, 2],
                    top: 8,
                    left: 0,
                    blur: 8,
                    color: "#000",
                    opacity: 0.35
                }
            },

            stroke: {
                width: [0, 3, 3],
                curve: "smooth"
            },

            colors: ["#EEEEEE", "#2196F3", "#FC776D"],

            tooltip: {
                theme: "dark"
            },

            plotOptions: {
                bar: {
                    columnWidth: "45%",
                    borderRadius: 0
                }
            },

            fill: {
                opacity: [1, 1, 1]
            },

            markers: {
                size: 0
            },

            grid: {
                borderColor: "#0d0d0d",
                strokeDashArray: 2,
                yaxis: {
                    lines: { show: true }
                }
            },

            xaxis: {
                categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                labels: {
                    style: {
                        fontSize: "13px",
                        fontWeight: 500,
                        colors: "#8A8A9C"
                    }
                },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },

            yaxis: {
                min: 0,
                tickAmount: 8,
                labels: {
                    formatter: function (val) {
                        return val.toFixed(0);
                    },
                    style: {
                        fontSize: "13px",
                        fontWeight: 500,
                        colors: "#8A8A9C"
                    }
                }
            },

            legend: {
                position: "top",
                horizontalAlign: "right",
                fontSize: "13px",
                markers: { radius: 4 }
            }
        };

        var chart = new ApexCharts(document.querySelector("#revenue-report"), revenueChart);
        chart.render();
    </script>
@endpush
@endcan

