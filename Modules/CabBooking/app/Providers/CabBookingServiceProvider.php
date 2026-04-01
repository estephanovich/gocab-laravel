<?php

namespace Modules\CabBooking\Providers;

use Exception;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Modules\CabBooking\Console\UpdateDateCommand;

class CabBookingServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'CabBooking';

    protected string $moduleNameLower = 'cabbooking';

    protected static bool $bootedOnce = false;

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->registerCommands();
        $this->registerCommandSchedules();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'database/migrations'));
        $this->loadFiles();
        if ($this->shouldRegisterAdminUi()) {
            if (self::$bootedOnce) {
                return;
            }
            $this->registerWidget();
            $this->registerQuickLinks();
            self::$bootedOnce = true;
        }
    }

    public function loadFiles(): void
    {
        $helperFile = __DIR__ . '/../Helpers/helper.php';
        if (file_exists($helperFile)) {
            require_once $helperFile;
        }
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(ObserverServiceProvider::class);
    }

    /**
     * Register commands in the format of Command::class
     */
    protected function registerCommands(): void
    {
        $this->commands([
            UpdateDateCommand::class
        ]);
    }
    /**
     * Register command Schedules.
     */
    protected function registerCommandSchedules(): void
    {
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->call('Modules\CabBooking\Http\Controllers\Api\RideController@rentalVehicleStatus');
            $schedule->call('Modules\CabBooking\Http\Controllers\Api\RideController@fetchTodayScheduleRide');
            $schedule->call('Modules\CabBooking\Http\Controllers\Api\RideController@offlineDrivers');
            $schedule->call('Modules\CabBooking\Http\Controllers\Api\PlanController@verifyIsExpiredSubscriptions');
            $schedule->call('Modules\CabBooking\Http\Controllers\Api\DocumentController@updateExpiredDriverDocuments');
            $schedule->call('Modules\CabBooking\Http\Controllers\Admin\PushNotificationController@scheduleStatus')->everyMinute();
        });
    }
    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/'.$this->moduleNameLower);
        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'lang'), $this->moduleNameLower);
            $this->loadJsonTranslationsFrom(module_path($this->moduleName, 'lang'));
        }
    }

    /**
     * Register config.
     */
    protected function registerConfig(): void
    {
        $this->publishes([module_path($this->moduleName, 'config/config.php') => config_path($this->moduleNameLower.'.php')], 'config');
        $this->mergeConfigFrom(module_path($this->moduleName, 'config/config.php'), $this->moduleNameLower);
    }

    /**
     * Register views.
     */
    public function registerViews(): void
    {
        $viewPath = resource_path('views/modules/'.$this->moduleNameLower);
        $sourcePath = module_path($this->moduleName, 'resources/views');
        $this->publishes([$sourcePath => $viewPath], ['views', $this->moduleNameLower.'-module-views']);
        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
        $componentNamespace = str_replace('/', '\\', config('modules.namespace').'\\'.$this->moduleName.'\\'.ltrim(config('modules.paths.generator.component-class.path'), config('modules.paths.app_folder', '')));
        Blade::componentNamespace($componentNamespace, $this->moduleNameLower);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<string>
     */
    public function provides(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (config('view.paths') as $path) {
            if (is_dir($path.'/modules/'.$this->moduleNameLower)) {
                $paths[] = $path.'/modules/'.$this->moduleNameLower;
            }
        }

        return $paths;
    }

    public function registerWidget()
    {
        try {

            addWidget(
                'ride_statistics',
                __('cabbooking::static.widget.ride_status_overviews'),
                function ($data) {
                    return view('cabbooking::admin.widgets.statistics');
                },
                [
                    'context' => 'normal',
                    'priority' => 'high',
                ]

            );
            addWidget(
                'ride_statistics',
                __('cabbooking::static.widget.fleet_managers_info'),
                function ($data) {
                    return view('cabbooking::admin.widgets.total-fleet-managers');
                },
                [
                    'context' => 'normal',
                    'priority' => 'high',
                ]
            );

            addWidget(
                'ride_status_overview',
                __('cabbooking::static.widget.ride_status_overviews'),
                function ($data) {
                    return view('cabbooking::admin.widgets.ride-status', ['rideStatusOverview' => true]);
                },
                [
                    'context' => 'normal',
                    'priority' => 'high',
                ]
            );

            addWidget(
                'services_chart',
                __('cabbooking::static.widget.services_chart'),
                function ($data) {
                    return view('cabbooking::admin.widgets.services');
                },
                [
                    'context' => 'normal',
                    'priority' => 'high',
                ]
            );
            addWidget(
                'top_drivers',
                __('cabbooking::static.widget.top_drivers'),
                function ($data) {
                    return view('cabbooking::admin.widgets.top-drivers', ['rideStatusOverview' => true]);
                },
                [
                    'context' => 'normal',
                    'priority' => 'high',
                ]
            );
            addWidget(
                'recent_rides',
                __('cabbooking::static.widget.recent_rides'),
                function ($data) {
                    return view('cabbooking::admin.widgets.recent-rides', ['rideStatusOverview' => true]);
                },
                [
                    'context' => 'normal',
                    'priority' => 'high',
                ]
            );
            addWidget(
                'average_revenue',
                __('cabbooking::static.widget.average_revenue'),
                function ($data) {
                    return view('cabbooking::admin.widgets.average-revenue', ['rideStatusOverview' => true]);
                },
                [
                    'context' => 'normal',
                    'priority' => 'high',
                ]
            );

        } catch (Exception $e) {

            // throw $e;
        }
    }

    public function registerQuickLinks()
    {
        try {

            add_quick_link(('cabbooking::static.rides.create_ride'), 'admin.ride-request.create', 'ri-steering-2-line', 'ride_request.create');
            add_quick_link(('cabbooking::static.locations.driver_location'), 'admin.driver-location.index', 'ri-map-pin-line', 'driver_location.index');
            add_quick_link(('cabbooking::static.drivers.add_driver'), 'admin.driver.create', 'ri-user-line', 'driver.create');
            add_quick_link(('cabbooking::static.zones.add'), 'admin.zone.create', 'ri-road-map-line', 'zone.create');

        } catch (Exception $e) {

            throw $e;
        }
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

