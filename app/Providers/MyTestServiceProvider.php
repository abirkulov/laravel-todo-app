<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\MyTestService;

class MyTestServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MyTestService::class, function() {
            return new MyTestService([
                'db' => 'MySQL', 
                'user' => 'Abirkulov Sherali',
                'website' => 'https://laravel.com'
            ]);
        });
    }
}
