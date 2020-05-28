<?php

namespace App\Providers;

use App\Models\Topic;
use App\Models\Reply;
use App\Observers\TopicObserver;
use App\Observers\ReplyObserver;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Topic::observe(TopicObserver::class);
        Reply::observe(ReplyObserver::class);
    }
}
