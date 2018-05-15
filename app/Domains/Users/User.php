<?php

namespace Emtudo\Domains\Users;

use Emtudo\Domains\Model;
use Emtudo\Domains\Users\Notifications\TwoFactorNotification;
use Emtudo\Domains\Users\Resources\Rules\UserRules;
use Emtudo\Domains\Users\Transformers\UserTransformer;
use Emtudo\Support\Notifications\ResetPassword as ResetPasswordNotification;
use Emtudo\Support\Shield\HasRules;
use Emtudo\Support\ViewPresenter\Presentable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class User extends Model implements AuditableContract, AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Auditable;
    use HasRules;
    use SoftDeletes;
    use Notifiable;
    use Authenticatable;
    use CanResetPassword;
    use Authorizable;
    use Presentable;

    public static $resetPasswordRoute;
    public static $twoFactoryIsValid = false;

    protected $auditExclude = [
      'id',
      'remember_token',
      'email_confirmed',
    ];

    /**
     * @var Rules class
     */
    protected static $rulesFrom = UserRules::class;

    /**
     * @var string user transformer class
     */
    protected $transformerClass = UserTransformer::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
    ];

    protected $dates = [
        'deleted_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @param string $value
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = mb_strtolower($value);
    }

    /**
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = app('hash')->driver('argon')->make($value);
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $route = str_replace('{token}', $token, rawurldecode(self::$resetPasswordRoute));

        $this->notify(new ResetPasswordNotification($route));
    }

    public function sendNotificationTwoFactor($code)
    {
        $this->notify(new TwoFactorNotification($code));
    }

    public function isAdmin()
    {
        return (bool) (int) $this->is_admin;
    }

    public function twoFactorEnabled()
    {
        return (bool) (int) $this->two_factor;
    }

    public function twoFactoryIsVerify()
    {
        return self::$twoFactoryIsValid;
    }

    public function customJWTClaims()
    {
        return [
        ];
    }

    public function getFirstNameAttribute()
    {
        return current(explode(' ', $this->name));
    }

    public function getLastNameAttribute()
    {
        $name = explode(' ', $this->name);
        unset($name[0]);

        return implode(' ', $name);
    }
}
