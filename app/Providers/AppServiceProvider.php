<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            return;
        }

        try {
            // Load settings from database
            $settings = Setting::pluck('value', 'name')->toArray();

            // Set or override config settings
            Config::set('mail.mailers.smtp.host', $settings['smtp_host'] ?? config('mail.mailers.smtp.host'));
            Config::set('mail.mailers.smtp.port', $settings['smtp_port'] ?? config('mail.mailers.smtp.port'));
            Config::set('mail.mailers.smtp.username', $settings['smtp_user'] ?? config('mail.mailers.smtp.username'));
            Config::set('mail.mailers.smtp.password', $settings['smtp_password'] ?? config('mail.mailers.smtp.password'));

        } catch (\Exception $e) {
            // Handle exception if settings table is not available, etc.
        }
    }
}
