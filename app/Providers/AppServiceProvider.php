<?php

namespace App\Providers;

use App\Models\Demo;
use App\Observers\DemoObserver;
use Cviebrock\EloquentSluggable\SluggableObserver;
use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        // Carbon 中文化配置
        Carbon::setLocale('zh');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Demo::observe(DemoObserver::class);
    }
}
