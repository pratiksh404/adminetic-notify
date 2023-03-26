<?php

namespace Adminetic\Notify\Provider;

use Adminetic\Notify\Http\Livewire\Admin\Notify\MyNotification;
use Adminetic\Notify\Http\Livewire\Admin\Notify\NotificationBell;
use Adminetic\Notify\Http\Livewire\Admin\Notify\NotificationSetting;
use Adminetic\Notify\Services\Notify;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;
use View;

class NotifyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishResource();
        }
        // Register Resources
        $this->registerResource();
        // Register View Components
        $this->registerLivewireComponents();
        // Register Blade Directive
        $this->bladeDirective();
    }

    /**
     * Publish Package Resource.
     *
     *@return void
     */
    protected function publishResource()
    {
        // Publish Config File
        $this->publishes([
            __DIR__ . '/../../config/notify.php' => config_path('notify.php'),
        ], 'notify-config');
    }

    /**
     * Register Package Resource.
     *
     *@return void
     */
    protected function registerResource()
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'notify'); // Loading Views Files
        $this->registerRoutes();
    }


    /**
     * Register Routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        });

        $this->loadRoutesFrom(__DIR__ . '/../../routes/channels.php');
    }

    /**
     * Register Route Configuration.
     *
     * @return array
     */
    protected function routeConfiguration()
    {
        return [
            'prefix' => config('adminetic.prefix', 'admin'),
            'middleware' => config('adminetic.middleware', ['web', 'auth']),
        ];
    }


    /**
     * Register Components.
     *
     *@return void
     */
    protected function registerLivewireComponents()
    {
        Livewire::component('notify.notification-setting', NotificationSetting::class);
        Livewire::component('notify.notification-bell', NotificationBell::class);
        Livewire::component('notify.my-notification', MyNotification::class);
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../../config/notify.php', 'notify');

        // Register the main class to use with the facade
        $this->app->singleton('notify', function () {
            return new Notify;
        });
    }

    /**
     * Register the application services.
     */
    public function bladeDirective()
    {
        Blade::directive('admineticNotification', function (string $expression) {
            return View::make('notify::admin.layouts.assets.notification');
        });
    }
}
