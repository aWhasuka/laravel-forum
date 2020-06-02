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

    Route::middleware('throttle:'.config('api.rate_limits.sign'))->group(function(){

        // 图片验证码
        Route::post('captchas', 'CaptchasController@store')
            ->name('captchas.store');

        // 短信验证码
        Route::post('verificationCodes', 'VerificationCodesController@store')->name('verificationCodes.store');

        // 用户注册
        Route::post('users', 'UsersController@store')->name('users.store');
    });


});
