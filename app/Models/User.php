<?php

namespace App\Models;

/**
 * MustVerifyEmail类说明：
 * /laravel/framework/src/Illuminate/Contracts/Auth/MustVerifyEmail.php ，
 * 可以看到此文件为 PHP 的接口类，继承此类将确保 User 遵守契约，拥有下面提到的四个方法。
 */
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Auth;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements MustVerifyEmailContract, JWTSubject
{
    /**
     *
     * 加载使用 MustVerifyEmail trait，打开 vendor/laravel/framework/src/Illuminate/Auth/MustVerifyEmail.php 文件，可以看到以下四个方法：
     * hasVerifiedEmail() 检测用户 Email 是否已认证；
     * markEmailAsVerified() 将用户标示为已认证；
     * sendEmailVerificationNotification() 发送 Email 认证的消息通知，触发邮件的发送；
     * getEmailForVerification() 获取发送邮件地址，提供这个接口允许你自定义邮箱字段。
     * 得益于 PHP 的 trait 功能，User 模型在 use 以后，即可使用以上四个方法
     */
    use MustVerifyEmailTrait;

    use Notifiable {
        notify as protected laravelNotify;
    }

    // getJWTIdentifier 返回了 User 的 id
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    // getJWTCustomClaims 是我们需要额外在 JWT 载荷中增加的自定义内容
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @param $instance
     * 我们对 notify() 方法做了一个巧妙的重写，现在每当你调用 $user->notify() 时，
     * users 表里的 notification_count 将自动 +1。
     */
    public function notify($instance)
    {
        // 如果要通知的人是当前用户，就不必通知了！
        if ($this->id == Auth::id()) {
            return;
        }

        // 只有数据库类型通知才需提醒，直接发送 Email 或者其他的都 Pass
        if (method_exists($instance, 'toDatabase')) {
            $this->increment('notification_count');
        }

        $this->laravelNotify($instance);
    }

    /**
     * The attributes that are mass assignable.
     * $fillable 属性的作用是防止用户随意修改模型数据，只有在此属性里定义的字段，才允许修改，否则更新时会被忽略。我们只需请按下图新增字段即可
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'email', 'password', 'introduction', 'avatar',
        'weixin_openid', 'weixin_unionid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'weixin_openid', 'weixin_unionid'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * 用户与话题中间的关系是 一对多 的关系，一个用户拥有多个主题，在 Eloquent 中使用 hasMany() 方法进行关联。
     * 关联设置成功后，我们即可使用 $user->topics 来获取到用户发布的所有话题数据。
     */
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    public function replies()
    {
        // 一个用户可以拥有多条评论
        return $this->hasMany(Reply::class);
    }

    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }
}
