<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CaptchaRequest;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CaptchasController extends Controller
{
    public function store(CaptchaRequest $request, CaptchaBuilder $captchaBuilder)
    {
        $key = 'captcha-'.Str::random(15);
        // 增加了 CaptchaRequest 要求用户必须通过手机号调用图片验证码接口
        $phone = $request->phone;

        // 注入 CaptchaBuilder，通过它的 build 方法，创建出来验证码图片
        $captcha = $captchaBuilder->build();

        /**
         * 这里给图片验证码设置为 2 分钟过期，并且考虑到图片验证码比较小，直接以 base64 格式返回图片，
         * 可以考虑在这里返回图片 url，例如 http://xxxx/captchas/{captcha_key}，然后访问该链接的时候生成并返回图片
         */
        $expiredAt = now()->addMinutes(2);

        // 使用 getPhrase 方法获取验证码文本，跟手机号一同存入缓存
        \Cache::put($key, ['phone' => $phone, 'code' => $captcha->getPhrase()], $expiredAt);

        // 返回 captcha_key，过期时间以及 inline 方法获取的 base64 图片验证码
        $result = [
            'captcha_key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
            'captcha_image_content' => $captcha->inline()
        ];

        return response()->json($result)->setStatusCode(201);
    }
}
