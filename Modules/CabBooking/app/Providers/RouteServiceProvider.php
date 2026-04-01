<?php

namespace Modules\CabBooking\Providers;

use Exception;
use App\Services\BadgeResolver;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Modules\CabBooking\Enums\RideStatusEnum;
use Modules\CabBooking\Http\Middleware\CabBookingAuthMiddleware;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'Modules\\CabBooking\\Http\\Controllers';
    protected $apiNamespace = 'Modules\\CabBooking\\Http\\Controllers\\Api';
    protected $webNamespace = 'Modules\\CabBooking\\Http\\Controllers';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     */
    public function boot(): void
    {
        parent::boot();
        $router = $this->app['router'];
        $router->aliasMiddleware('cabbooking.auth', CabBookingAuthMiddleware::class);
    }

    /**
     * Define the routes for the application.
     */
    public function map(): void
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        if ($this->shouldRegisterAdminUi()) {
            $this->registerMenus();
            $this->registerBadgeHandlers();
        }
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware('web')->prefix('cab')->namespace($this->webNamespace)->group(module_path('CabBooking', '/routes/web.php'));
        Route::middleware('web')->prefix('admin')->namespace($this->namespace)->group(module_path('CabBooking', '/routes/admin.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapApiRoutes(): void
    {
        Route::middleware('api')->namespace($this->apiNamespace)->prefix('api')->group(module_path('CabBooking', '/routes/api/api.php'));
        Route::middleware('api')->namespace($this->apiNamespace)->prefix('api')->group(module_path('CabBooking', '/routes/api/admin.php'));
    }

    protected function registerMenus()
    {
        try {

            add_menu(label: 'cabbooking::sidebar.riders', module_slug: 'cabbooking', slug: 'tx_riders', icon: 'ri-group-line', position: 3, section: 'sidebar.user_management', permission: 'rider.index');
            add_menu(label: 'cabbooking::sidebar.all_riders', route: 'admin.rider.index', parent_slug: 'tx_riders', module_slug: 'cabbooking', slug: 'tx_all_riders', icon: 'ri-team-line', section: 'sidebar.user_management', permission: 'rider.index');
            add_menu(label: 'cabbooking::sidebar.add_rider', route: 'admin.rider.create', parent_slug: 'tx_riders', module_slug: 'cabbooking', slug: 'tx_rider_create', icon: 'ri-user-add-line', section: 'sidebar.user_management', permission: 'rider.create');
            add_menu(label: 'cabbooking::sidebar.wallet', route: 'admin.rider-wallet.index', parent_slug: 'tx_riders', module_slug: 'cabbooking', slug: 'tx_rider_wallet', icon: 'ri-wallet-line', section: 'sidebar.user_management', permission: 'rider_wallet.index');

            add_menu(label: 'cabbooking::sidebar.drivers', module_slug: 'cabbooking', slug: 'tx_drivers', icon: 'ri-user-2-line', position: 4, section: 'sidebar.user_management', permission: 'driver.index');
            add_menu(label: 'cabbooking::sidebar.verified_drivers', route: 'admin.driver.index', parent_slug: 'tx_drivers', module_slug: 'cabbooking', slug: 'tx_all_drivers', icon: 'ri-check-line', section: 'sidebar.user_management', permission: 'driver.index');
            add_menu(label: 'cabbooking::sidebar.unverified_drivers', route: 'admin.driver.unverified-drivers', parent_slug: 'tx_drivers', module_slug: 'cabbooking', slug: 'tx_unverified_drivers', icon: 'ri-alert-line', section: 'sidebar.user_management', permission: 'unverified_driver.index', badge: 0, badgeable: true);
            add_menu(label: 'cabbooking::sidebar.add_driver', route: 'admin.driver.create', parent_slug: 'tx_drivers', module_slug: 'cabbooking', slug: 'tx_driver_add', icon: 'ri-add-line', section: 'sidebar.user_management', permission: 'driver.create');
            add_menu(label: 'cabbooking::sidebar.driver_documents', route: 'admin.driver-document.index', parent_slug: 'tx_drivers', module_slug: 'cabbooking', slug: 'tx_driverDocument', icon: 'ri-document-line', section: 'sidebar.user_management', permission: 'driver_document.index', badge: 0, badgeable: true);
            add_menu(label: 'cabbooking::sidebar.driver_rules', route: 'admin.driver-rule.index', parent_slug: 'tx_drivers', module_slug: 'cabbooking', slug: 'tx_driverRule', icon: 'ri-gavel-line', section: 'sidebar.user_management', permission: 'driver_rule.index');
            add_menu(label: 'cabbooking::sidebar.driver_location', route: 'admin.driver-location.index', parent_slug: 'tx_drivers', module_slug: 'cabbooking', slug: 'tx_locations', icon: 'ri-road-map-line', section: 'sidebar.user_management', permission: 'driver_location.index');

            add_menu(label: 'cabbooking::sidebar.notice', slug:'tx_notices', route: 'admin.notice.index', parent_slug: 'tx_drivers', module_slug: 'cabbooking', icon: 'ri-notice-line', section: 'sidebar.user_management', permission: 'notice.index');
            add_menu(label: 'cabbooking::sidebar.wallet', slug:'tx_driver_wallet', route: 'admin.driver-wallet.index', parent_slug: 'tx_drivers', module_slug: 'cabbooking', icon: 'ri-wallet-line', section: 'sidebar.user_management', permission: 'driver_wallet.index');
            add_menu(label: 'cabbooking::sidebar.withdraw_requests', route: 'admin.withdraw-request.index', parent_slug: 'tx_drivers', module_slug: 'cabbooking', slug: 'tx_withdrawRequest', icon: 'ri-money-dollar-circle-line', section: 'sidebar.user_management', permission: 'withdraw_request.index', badge: 0, badgeable: true);
            add_menu(label: 'cabbooking::sidebar.commission_histories', route: 'admin.cab-commission-history.index', parent_slug: 'tx_drivers', module_slug: 'cabbooking', slug: 'tx_commissionHistory', icon: 'ri-money-dollar-circle-line', section: 'sidebar.user_management', permission: 'cab_commission_history.index');

            add_menu(label: 'cabbooking::sidebar.dispatchers', module_slug: 'cabbooking', slug: 'tx_dispatcher', icon: 'ri-group-line', section: 'sidebar.user_management',  position: 5, permission: 'rider.index');
            add_menu(label: 'cabbooking::sidebar.all_dispatchers', route: 'admin.dispatcher.index', parent_slug: 'tx_dispatcher', module_slug: 'cabbooking', slug: 'tx_all_dispatchers', icon: 'ri-team-line', section: 'sidebar.user_management', permission: 'dispatcher.index');
            add_menu(label: 'cabbooking::sidebar.add_dispatcher', route: 'admin.dispatcher.create', parent_slug: 'tx_dispatcher', module_slug: 'cabbooking', slug: 'tx_dispatcher_create', icon: 'ri-user-add-line', section: 'sidebar.user_management', permission: 'dispatcher.create');

            add_menu(label: 'cabbooking::sidebar.fleet_managers', module_slug: 'cabbooking', slug: 'tx_fleet_manager', icon: 'ri-truck-line', section: 'sidebar.user_management', position: 6, permission: 'fleet_manager.index');
            add_menu(label: 'cabbooking::sidebar.verified_fleet_managers', route: 'admin.fleet-manager.index', parent_slug: 'tx_fleet_manager', module_slug: 'cabbooking', slug: 'tx_all_fleet_managers', icon: 'ri-team-line', section: 'sidebar.user_management', permission: 'fleet_manager.index');
            add_menu(label: 'cabbooking::sidebar.add_fleet_manager', route: 'admin.fleet-manager.create', parent_slug: 'tx_fleet_manager', module_slug: 'cabbooking', slug: 'tx_fleet_manager_create', icon: 'ri-user-add-line', section: 'sidebar.user_management', permission: 'fleet_manager.create');
            add_menu(label: 'cabbooking::sidebar.fleet_documents', route: 'admin.fleet-document.index', parent_slug: 'tx_fleet_manager', module_slug: 'cabbooking', slug: 'tx_fleetDocument', icon: 'ri-document-line', section: 'sidebar.user_management', permission: 'fleet_document.index', badge: 0, badgeable: true);

            add_menu(label: 'cabbooking::sidebar.fleet_vehicles', module_slug: 'cabbooking', slug: 'tx_fleet_vehicles', icon: 'ri-car-line', section: 'sidebar.user_management',  position: 7, permission: 'vehicle_info.index');
            add_menu(label: 'cabbooking::sidebar.verified_fleet_vehicles', route: 'admin.vehicle-info.verified', parent_slug: 'tx_fleet_vehicles', module_slug: 'cabbooking', slug: 'tx_verified_fleet_vehicles', icon: 'ri-check-line', section: 'sidebar.user_management', permission: 'vehicle_info.index');
            add_menu(label: 'cabbooking::sidebar.unverified_fleet_vehicles', route: 'admin.vehicle-info.unverified', parent_slug: 'tx_fleet_vehicles', module_slug: 'cabbooking', slug: 'tx_unverified_fleet_vehicles', icon: 'ri-alert-line', section: 'sidebar.user_management', permission: 'vehicle_info.index');

            add_menu(label: 'cabbooking::sidebar.fleet_vehicle_documents', route: 'admin.vehicleInfoDoc.index', parent_slug: 'tx_fleet_manager', position: 8,  module_slug: 'cabbooking', slug: 'tx_vehicleInfoDoc', icon: 'ri-document-line', section: 'sidebar.user_management', permission: 'fleet_vehicle_document.index', badge: 0, badgeable: true);
            add_menu(label: 'cabbooking::sidebar.wallet', route: 'admin.fleet-wallet.index', parent_slug: 'tx_fleet_manager', module_slug: 'cabbooking', slug: 'tx_fleet_manager_wallet',icon: 'ri-wallet-line', section: 'sidebar.user_management', permission: 'fleet_wallet.index');
            add_menu(label: 'cabbooking::sidebar.withdraw_requests', route: 'admin.fleet-withdraw-request.index', parent_slug: 'tx_fleet_manager', module_slug: 'cabbooking', slug: 'tx_fleet_withdrawRequest', icon: 'ri-money-dollar-circle-line', section: 'sidebar.user_management', permission: 'fleet_withdraw_request.index', badge: 0, badgeable: true);

            add_menu(label: 'cabbooking::sidebar.referrals', route: 'admin.referral.index', module_slug: 'cabbooking', slug: 'tx_referral_bonus', icon: 'ri-user-shared-line', position: 9, section: 'sidebar.user_management', permission: 'cab_referral.index');

            add_menu(label: 'cabbooking::sidebar.zones', module_slug: 'cabbooking', slug: 'zones', icon: 'ri-route-line', position: 6, section: 'cabbooking::sidebar.cab_management', permission: 'zone.index');
            add_menu(label: 'cabbooking::sidebar.zones', route: 'admin.zone.index', parent_slug: 'zones', module_slug: 'cabbooking', slug: 'tx_zones', icon: 'ri-map-2-line', section: 'cabbooking::sidebar.cab_management', permission: 'zone.index');
            add_menu(label: 'cabbooking::sidebar.add_zone', route: 'admin.zone.create', parent_slug: 'zones', module_slug: 'cabbooking', slug: 'tx_zones_create', icon: 'ri-map-2-line', section: 'cabbooking::sidebar.cab_management', permission: 'zone.create');

            add_menu(label: 'cabbooking::sidebar.peak_zones', module_slug: 'cabbooking', slug: 'tx_peakZones', icon: 'ri-shape-line', position: 7, section: 'cabbooking::sidebar.cab_management', permission: 'peak_zone.index');
            add_menu(label: 'cabbooking::sidebar.peak_zones', route: 'admin.peakZone.index', module_slug: 'cabbooking',  parent_slug: 'tx_peakZones',slug: 'tx_peakZones_list',position: 8, icon: 'ri-fire-line', section: 'cabbooking::sidebar.cab_management', permission: 'peak_zone.index');
            add_menu(label: 'cabbooking::sidebar.peak_zone_map', route: 'admin.peakZoneMap.index', module_slug: 'cabbooking', parent_slug: 'tx_peakZones', slug: 'tx_peakzone_map', position: 9, icon: 'ri-map-pin-line', section: 'cabbooking::sidebar.cab_management', permission: 'peak_zone.index');

            add_menu(label: 'cabbooking::sidebar.services', route: 'admin.service.index', module_slug: 'cabbooking', slug: 'tx_service', icon: 'ri-pin-distance-line', position: 7, section: 'cabbooking::sidebar.cab_management', permission: 'service.index');
            add_menu(label: 'cabbooking::sidebar.cab', module_slug: 'cabbooking', slug: 'tx_service_cab', icon: 'ri-roadster-line', position: 8, section: 'sidebar.home', permission: 'service.index');
            add_menu(label: 'cabbooking::sidebar.service_categories', route: 'admin.service-category.cab.index', module_slug: 'cabbooking',  parent_slug: 'tx_service_cab', slug: 'tx_service_categories_cab', icon: 'ri-taxi-line', position: 8, section: 'sidebar.home', permission: 'service.index');
            add_menu(label: 'cabbooking::sidebar.vehicles', route: 'admin.vehicle-type.cab.index', module_slug: 'cabbooking',  parent_slug: 'tx_service_cab', slug: 'tx_service_categories_vehicle_cab', icon: 'ri-taxi-line', position: 8, section: 'sidebar.home', permission: 'service.index');




            add_menu(label: 'cabbooking::sidebar.freight', module_slug: 'cabbooking', slug: 'tx_service_freight', icon: 'ri-truck-line', position: 9, section: 'sidebar.home', permission: 'service.index');
            add_menu(label: 'cabbooking::sidebar.service_categories', route: 'admin.service-category.freight.index', module_slug: 'cabbooking',  parent_slug: 'tx_service_freight', slug: 'tx_service_categories_freight', icon: 'ri-taxi-line', position: 8, section: 'sidebar.home', permission: 'service.index');
            add_menu(label: 'cabbooking::sidebar.vehicles', route: 'admin.vehicle-type.freight.index', module_slug: 'cabbooking',  parent_slug: 'tx_service_freight', slug: 'tx_service_categories_vehicle_freight', icon: 'ri-taxi-line', position: 8, section: 'sidebar.home', permission: 'service.index');

            add_menu(label: 'cabbooking::sidebar.parcel', module_slug: 'cabbooking', slug: 'tx_service_parcel', icon: 'ri-archive-2-line', position: 9, section: 'sidebar.home', permission: 'service.index');
            add_menu(label: 'cabbooking::sidebar.service_categories', route: 'admin.service-category.parcel.index', module_slug: 'cabbooking',  parent_slug: 'tx_service_parcel', slug: 'tx_service_categories_parcel', icon: 'ri-taxi-line', position: 8, section: 'sidebar.home', permission: 'service.index');
            add_menu(label: 'cabbooking::sidebar.vehicles', route: 'admin.vehicle-type.parcel.index',  module_slug: 'cabbooking',  parent_slug: 'tx_service_parcel', slug: 'tx_service_categories_vehicle_parcel', icon: 'ri-taxi-line', position: 8, section: 'sidebar.home', permission: 'service.index');

            add_menu(label: 'cabbooking::sidebar.heat_map', route: 'admin.heat-map', module_slug: 'cabbooking', slug: 'tx_heatmap', position: 9, icon: 'ri-fire-line', section: 'cabbooking::sidebar.cab_management', permission: 'heat_map.index');
            add_menu(label: 'cabbooking::sidebar.preferences', route: 'admin.preference.index', module_slug: 'cabbooking', slug: 'tx_preference_index', position: 9, icon: 'ri-equalizer-2-line', section: 'cabbooking::sidebar.cab_management', permission: 'preference.index');



            add_menu(label: 'cabbooking::sidebar.sos', module_slug: 'cabbooking', slug: 'tx_sos', icon: 'ri-alarm-warning-line', position: 11, section: 'cabbooking::sidebar.cab_management', permission: 'sos.index');
            add_menu(label: 'cabbooking::sidebar.sos', route: 'admin.sos.index', parent_slug: 'tx_sos', module_slug: 'cabbooking', slug: 'tx_soses', icon: 'ri-alert-line', section: 'cabbooking::sidebar.cab_management', permission: 'sos.index');
            add_menu(label: 'cabbooking::sidebar.sos_alerts', route: 'admin.sos-alerts.index', parent_slug: 'tx_sos', module_slug: 'cabbooking', slug: 'tx_sos_alerts', icon: 'ri-list-check', section: 'cabbooking::sidebar.cab_management', permission: 'sos_alert.index');

            add_menu(label: 'cabbooking::sidebar.subscriptions', module_slug: 'cabbooking', slug: 'tx_subscription', icon: 'ri-vip-crown-line', position: 12, section: 'cabbooking::sidebar.price_management', permission: 'plan.index');
            add_menu(label: 'cabbooking::sidebar.driver_subscription', route: 'admin.driver-subscription.index', parent_slug: 'tx_subscription', module_slug: 'cabbooking', slug: 'tx_driverSubscription', icon: 'ri-file-blank-line', section: 'cabbooking::sidebar.price_management', permission: 'subscription.index');
            add_menu(label: 'cabbooking::sidebar.plans', route: 'admin.plan.index', parent_slug: 'tx_subscription', module_slug: 'cabbooking', slug: 'tx_plans', icon: 'ri-gavel-line', section: 'cabbooking::sidebar.price_management', permission: 'plan.index');

            add_menu(label: 'cabbooking::sidebar.coupons', route: 'admin.coupon.index', module_slug: 'cabbooking', slug: 'tx_coupons', icon: 'ri-coupon-2-line', position: 13, section: 'cabbooking::sidebar.price_management', permission: 'coupon.index');
            add_menu(label: 'cabbooking::sidebar.extra_charges', route: 'admin.extra-charge.index', module_slug: 'cabbooking', slug: 'tx_extraCharges', icon: 'ri-money-dollar-circle-line', position: 13, section: 'cabbooking::sidebar.price_management', permission: 'extra_charge-2.index');
            add_menu(label: 'cabbooking::sidebar.surge_prices',route: 'admin.surge-price.index', module_slug: 'cabbooking',slug: 'tx_surge_price',icon: 'ri-price-tag-3-line',position: 14,section: 'cabbooking::sidebar.price_management', permission: 'surge_price.index');
            add_menu(label: 'cabbooking::sidebar.airports',route: 'admin.airport.index',module_slug: 'cabbooking',slug: 'tx_airport',icon: 'ri-plane-line',section: 'cabbooking::sidebar.cab_management',position: 15,permission: 'airport.index');

            add_menu(label: 'cabbooking::sidebar.reports',module_slug: 'cabbooking', slug:'tx_reports', icon: 'ri-folder-chart-line', section:'cabbooking::sidebar.cab_management', position:16,permission:'report.index');
            add_menu(label: 'cabbooking::sidebar.transaction_reports', route:'admin.transaction-report.index', parent_slug: 'tx_reports', module_slug: 'cabbooking', slug:'tx_transaction_reports', icon: 'ri-road-line', section:'cabbooking::sidebar.cab_management',permission:'report.index');
            add_menu(label: 'cabbooking::sidebar.ride_reports', route:'admin.ride-report.index', parent_slug: 'tx_reports', module_slug: 'cabbooking', slug:'tx_ride_reports', icon: 'ri-traffic-line', section:'cabbooking::sidebar.cab_management',permission:'report.index');
            add_menu(label: 'cabbooking::sidebar.driver_reports', route:'admin.driver-report.index', parent_slug: 'tx_reports', module_slug: 'cabbooking', slug:'tx_driver_reports', icon: 'ri-user-line', section:'cabbooking::sidebar.cab_management',permission:'report.index');
            add_menu(label: 'cabbooking::sidebar.coupon_reports', route:'admin.coupon-report.index', parent_slug: 'tx_reports', module_slug: 'cabbooking', slug:'tx_coupon_reports', icon: 'ri-road-line', section:'cabbooking::sidebar.cab_management',permission:'report.index');
            add_menu(label: 'cabbooking::sidebar.zone_reports', route:'admin.zone-report.index', parent_slug: 'tx_reports', module_slug: 'cabbooking', slug:'tx_zone_reports', icon: 'ri-bar-chart-2-line', section:'cabbooking::sidebar.cab_management',permission:'report.index');
            add_menu(label: 'cabbooking::sidebar.incentive_reports', route:'admin.incentive-report.index', parent_slug: 'tx_reports', module_slug: 'cabbooking', slug:'tx_incentive_reports', icon: 'ri-bar-chart-2-line', section:'cabbooking::sidebar.cab_management',permission:'report.index');

            add_menu(label: 'cabbooking::sidebar.reviews', module_slug: 'cabbooking', slug:'tx_reviews', icon:'ri-user-star-line', section:'cabbooking::sidebar.cab_management', position:17, permission:'driver_review.index');
            add_menu(label: 'cabbooking::sidebar.rider_reviews', route: 'admin.rider-review.index', parent_slug: 'tx_reviews', module_slug: 'cabbooking', slug: 'tx_rider_review', icon: 'ri-star-line', section: 'cabbooking::sidebar.cab_management', permission: 'rider.create');
            add_menu(label: 'cabbooking::sidebar.driver_reviews',  route: 'admin.driver-review.index', parent_slug: 'tx_reviews', module_slug: 'cabbooking', slug: 'tx_driver_review', icon: 'ri-star-line', section: 'cabbooking::sidebar.cab_management', permission: 'driver_review.index');

            // APP settings
            add_menu(label: 'cabbooking::sidebar.app_settings', route:'admin.cabbooking-setting.index', parent_slug: '', module_slug: 'cabbooking', slug:'tx_setting', icon: 'ri-settings-4-line',position: 18, section:'cabbooking::sidebar.cab_management', permission:'cabbooking_setting.index');

            add_menu(label: 'cabbooking::sidebar.vehicles', module_slug: 'cabbooking', slug: 'tx_vehicles', icon: 'ri-taxi-line', position: 10, section: 'cabbooking::sidebar.cab_management', permission:'rental_vehicle.index');
            add_menu(label: 'cabbooking::sidebar.rental_vehicles', route: 'admin.rental-vehicle.index', parent_slug: 'tx_vehicles', module_slug: 'cabbooking', slug: 'tx_rental_vehicle', icon: 'ri-clock-line', section: 'cabbooking::sidebar.cab_management', permission: 'rental_vehicle.index');
            add_menu(label: 'cabbooking::sidebar.ambulances', route: 'admin.ambulance.index', parent_slug: 'tx_vehicles', module_slug: 'cabbooking', slug: 'tx_ambulance', icon: 'ri-ambulance-fill', section: 'cabbooking::sidebar.cab_management', permission: 'ambulance.index');
            add_menu(label: 'cabbooking::sidebar.hourly_packages', route: 'admin.hourly-package.index', parent_slug: 'tx_vehicles', module_slug: 'cabbooking', slug: 'tx_hourlyPackage', icon: 'ri-clock-line', section: 'cabbooking::sidebar.cab_management', permission: 'hourly_package.index');
            add_menu(label: 'cabbooking::sidebar.documents', route:'admin.document.index', parent_slug: 'tx_vehicles',module_slug: 'cabbooking', slug:'tx_documents', icon:'ri-file-line', section:'cabbooking::sidebar.cab_management', permission:'document.index');
            add_menu(label: 'cabbooking::sidebar.cancellation_reasons', route:'admin.cancellation-reason.index', parent_slug: 'tx_vehicles', module_slug: 'cabbooking', slug:'tx_cancellationReason', icon: 'ri-error-warning-line', section:'cabbooking::sidebar.cab_management', permission:'cancellation_reason.index');



            add_menu(label: 'cabbooking::sidebar.rides', module_slug: 'cabbooking', slug:'tx_ride', icon:'ri-map-2-line', section:'sidebar.home', position:10, permission:'ride.index');
            add_menu(label: 'cabbooking::sidebar.ride_requests', route:'admin.ride-request.index', parent_slug: 'tx_ride', module_slug: 'cabbooking', slug:'tx_all_ride_requests', icon: 'ri-traffic-light-line', section:'sidebar.home', permission:'ride_request.index');
            add_menu(label: 'cabbooking::sidebar.all_rides', route:'admin.ride.index', parent_slug: 'tx_ride', module_slug: 'cabbooking', slug:'tx_all_rides', icon: 'ri-traffic-light-line', section:'sidebar.home', permission:'ride.index');
            add_menu(label: 'cabbooking::sidebar.scheduled_rides', route:'admin.ride.status.filter', params:['status' => RideStatusEnum::SCHEDULED], parent_slug: 'tx_ride', module_slug: 'cabbooking', slug:'tx_scheduled_rides', icon: 'ri-traffic-light-line', section:'sidebar.home', permission:'ride.index', badge: 0, badgeable: true); // getTotalRidesByStatus(RideStatusEnum::SCHEDULED)
            add_menu(label: 'cabbooking::sidebar.accepted_rides', route:'admin.ride.status.filter', params:['status' => RideStatusEnum::ACCEPTED], parent_slug: 'tx_ride', module_slug: 'cabbooking', slug:'tx_accepted_rides', icon: 'ri-traffic-light-line', section:'sidebar.home', permission:'ride.index', badge: 0, badgeable: true); // getTotalRidesByStatus(RideStatusEnum::ACCEPTED)
            add_menu(label: 'cabbooking::sidebar.arrived_rides', route: 'admin.ride.status.filter',  params:['status' => RideStatusEnum::ARRIVED], parent_slug: 'tx_ride', module_slug: 'cabbooking', slug: 'tx_arrived_rides', icon: 'ri-traffic-light-line', section: 'sidebar.home', permission: 'ride.index', badge: 0, badgeable: true); // getTotalRidesByStatus(RideStatusEnum::ARRIVED)
            add_menu(label: 'cabbooking::sidebar.started_rides', route:'admin.ride.status.filter',  params:['status' => RideStatusEnum::STARTED],parent_slug: 'tx_ride', module_slug: 'cabbooking', slug:'tx_started_rides', icon: 'ri-traffic-light-line', section:'sidebar.home', permission:'ride.index', badge: 0, badgeable: true); // getTotalRidesByStatus(RideStatusEnum::STARTED)
            add_menu(label: 'cabbooking::sidebar.cancelled_rides', route:'admin.ride.status.filter',  params:['status' => RideStatusEnum::CANCELLED],parent_slug: 'tx_ride', module_slug: 'cabbooking', slug:'tx_cancelled_rides', icon: 'ri-traffic-light-line', section:'sidebar.home', permission:'ride.index', badge: 0, badgeable: true); // getTotalRidesByStatus(RideStatusEnum::CANCELLED)
            add_menu(label: 'cabbooking::sidebar.completed_rides', route:'admin.ride.status.filter', params:['status' => RideStatusEnum::COMPLETED],  parent_slug: 'tx_ride', module_slug: 'cabbooking', slug:'tx_completed_rides', icon: 'ri-traffic-light-line', section:'sidebar.home', permission:'ride.index', badge: 0, badgeable: true);

            add_menu(label: 'cabbooking::sidebar.banners', route: 'admin.banner.index', module_slug: 'cabbooking', slug: 'tx_banners', icon: 'ri-todo-line', section: 'sidebar.promotion_management', permission: 'banner.index');
            add_menu(label: 'cabbooking::sidebar.onboardings', route: 'admin.onboarding.index', module_slug: 'cabbooking', slug: 'tx_onboardings', icon: 'ri-guide-line', section: 'sidebar.promotion_management', permission: 'onboarding.index');
            add_menu(label: 'cabbooking::sidebar.push_notification',   module_slug: 'cabbooking', slug: 'tx_pushNotification', icon: 'ri-send-plane-line', section: 'sidebar.promotion_management', position: 19, permission: 'push_notification.index');
            add_menu(label: 'cabbooking::sidebar.all_push_notifications', route: 'admin.push-notification.index', parent_slug: 'tx_pushNotification', module_slug: 'cabbooking', slug: 'tx_all_pushNotification', icon: 'ri-notification-2-line', section: 'sidebar.promotion_management', permission: 'push_notification.index');
            add_menu(label: 'cabbooking::sidebar.send_push_notification', route: 'admin.push-notification.create', parent_slug: 'tx_pushNotification', module_slug: 'cabbooking', slug: 'tx_send_pushNotification', icon: 'ri-send-plane-line', section: 'sidebar.promotion_management', permission: 'push_notification.create');

            add_menu(label: 'cabbooking::sidebar.chats', route: 'admin.chat.index', module_slug: 'cabbooking', position: 4, slug: 'tx_chat', icon: 'ri-chat-1-line', section: 'sidebar.home', permission: 'chat.index');

        } catch (Exception $e) {

           Log::error("Cab service provider:", ['message'=>$e->getMessage()]);
        }
    }

    protected function registerBadgeHandlers()
    {
        $resolver = app(BadgeResolver::class);

        $statusMap = [
            'tx_scheduled_rides' => RideStatusEnum::SCHEDULED,
            'tx_accepted_rides' => RideStatusEnum::ACCEPTED,
            'tx_arrived_rides' => RideStatusEnum::ARRIVED,
            'tx_started_rides' => RideStatusEnum::STARTED,
            'tx_cancelled_rides' => RideStatusEnum::CANCELLED,
            'tx_completed_rides' => RideStatusEnum::COMPLETED,
        ];

        foreach ($statusMap as $slug => $status) {
            $resolver->register($slug, function ($user) use ($status) {
                return getTotalRidesByStatus($status);
            });
        }

        $resolver->register('tx_withdrawRequest', function ($user) {
            return getPendingWithdrawRequests();
        });

        $resolver->register('tx_fleet_withdrawRequest', function ($user) {
            return getPendingFleetWithdrawRequests();
        });

        $resolver->register('tx_driverDocument', function ($user) {
            return getAllDriverDocumentsCount();
        });

        $resolver->register('tx_unverified_drivers',function ($user) {
            return getUnverifiedDriver();
        });

    }

    protected function shouldRegisterAdminUi(): bool
    {
        if ($this->app->runningInConsole()) {
            return false;
        }

        $request = request();
        if ($request->expectsJson() || $request->isJson() || $request->wantsJson()) {
            return false;
        }

        return true;
    }
}
