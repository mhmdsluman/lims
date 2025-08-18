<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            return;
        }

        // Check if the settings table exists
        if (Schema::hasTable('settings')) {
            $settings = Setting::all();
            foreach ($settings as $setting) {
                $key = 'settings.' . $setting->key;
                $value = json_decode($setting->value, true);

                // If json_decode fails, it returns null, so we use the original value.
                $configValue = is_null($value) ? $setting->value : $value;

                config([$key => $configValue]);
            }
        }
    }
}
