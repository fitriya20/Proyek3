<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class WhatsappServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        require_once app_path() . '/Helpers/Whatsapp.php';
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
