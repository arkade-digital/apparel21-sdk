<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Monolog\Handler\LogEntriesHandler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Configure remote logging services.
     *
     * @return void
     */
    protected function configureRemoteLogging()
    {
        // Configure LogEntries.
        if (config('services.logentries.token')) {
            Log::getMonolog()->pushHandler(new LogEntriesHandler(config('services.logentries.token')));
        }
    }
}
