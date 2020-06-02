<?php
/*
 * @Author: aWhasuka
 * @Package: 亿菜场
 * @Date: 2020-05-19
 */ 

namespace App\Providers;

use App\Models\Topic;
use App\Models\Reply;
use App\Observers\TopicObserver;
use App\Observers\ReplyObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\Resource;

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

        // 当有数据嵌套时，数据嵌套的层数会特别多，所以我们选择去掉 data 这一层包裹。
        Resource::withoutWrapping();
    }
}
