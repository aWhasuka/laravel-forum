<?php
/*
 * @Author: aWhasuka
 * @Package: 亿菜场
 * @Date: 2020-05-19
 */

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->namespace('Api\v1')->name('api.v1.')->group(function () {

    // 调用频率限制
    Route::middleware('throttle:'.config('api.rate_limits.sign'))->group(function(){

        // 图片验证码
        Route::post('captchas', 'CaptchasController@store')
            ->name('captchas.store');

        // 短信验证码
        Route::post('verificationCodes', 'VerificationCodesController@store')->name('verificationCodes.store');

        // 用户注册
        Route::post('users', 'UsersController@store')->name('users.store');

        // 第三方登录
        // 对 social_type 进行了限制，只会匹配 weixin，如果你增加了其他的第三方登录，可以再这里增加限制，例如支持微信及微博：->where('social_type', 'weixin|weibo') 。
        Route::post('socials/{social_type}/authorizations', 'AuthorizationsController@socialStore')
            ->where('social_type', 'weixin')
            ->name('socials.authorizations.store');

        // 登录
        Route::post('authorizations', 'AuthorizationsController@store')
            ->name('api.authorizations.store');

        // 刷新token
        Route::put('authorizations/current', 'AuthorizationsController@update')
            ->name('authorizations.update');

        // 删除token
        Route::delete('authorizations/current', 'AuthorizationsController@destroy')
            ->name('authorizations.destroy');

    });

    // 统一 1 分钟只能调 用 60 次
    Route::middleware('throttle:'.config('api.rate_limits.access'))->group(function () {
        // 游客可以访问的接口

        // 某个用户的详情
        Route::get('users/{user}', 'UsersController@show')
            ->name('users.show');

        // 分类列表
        Route::get('categories', 'CategoriesController@index')
            ->name('categories.index');

        // 话题列表
        Route::resource('topics', 'TopicsController')->only(['index', 'show']);

        // 某个用户发布的话题
        Route::get('users/{user}/topics', 'TopicsController@userIndex')
            ->name('users.topics.index');

        // 登录后可以访问的接口
        Route::middleware('auth:api')->group(function() {
            // 当前登录用户信息
            Route::get('user', 'UsersController@me')
                ->name('user.show');

            // 编辑登录用户信息
            // put 替换某个资源，需提供完整的资源信息；
            // patch 部分修改资源，提供部分资源信息。
            Route::patch('user', 'UsersController@update')
                ->name('user.update');

            // 上传图片
            Route::post('images', 'ImagesController@store')
                ->name('images.store');

            // 发布话题
            Route::resource('topics', 'TopicsController')
                ->only(['store', 'update', 'destroy']);

            // 发布回复
            Route::post('topics/{topic}/replies', 'RepliesController@store')
                ->name('topics.replies.store');

            // 删除回复
            Route::delete('topics/{topic}/replies/{reply}', 'RepliesController@destroy')
                ->name('topics/replies.destroy');

        });

    });

});
