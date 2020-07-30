<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;

/**
 * Class User
 * @package App\Models
 *
 * @property Role roles
 * @property Permission permissions
 * @property DatabaseNotification notifications
 * @property int id
 * @property string name
 * @property string email
 * @property string|\Carbon\Carbon email_verified_at
 * @property string password
 * @property string remember_token
 * @property string|\Carbon\Carbon created_at
 * @property string|\Carbon\Carbon updated_at
 * @property string|\Carbon\Carbon deleted_at
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, LaratrustUserTrait, Notifiable, SoftDeletes;

    protected $dates = [
        'email_verified_at',
        'deleted_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'balance',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'email' => 'string',
        'password' => 'string',
        'balance' => 'float',
    ];

    /**
     * Regras para Register do App
     *
     * @var array
     */
    public static $register_rules = [
        'name' => 'required|max:255',
        'email' => 'required|max:255|email|unique:users,email',
        'password' => 'required|confirmed|min:6',
    ];

    /**
     * Regras para Atualizar Senha do App
     *
     * @var array
     */
    public static $reset_password_rules = [
        'token' => 'required',
        'email' => 'required|email|exists:users,email',
        'password' => 'required|confirmed|min:6',
    ];

    /**
     * Regras para Atualizar Senha do App
     *
     * @var array
     */
    public static $update_password_rules = [
        'current_password' => 'required|password:api',
        'password' => 'required|confirmed|min:6',
    ];

    /**
     * Regras para Atualizar Profile do App
     *
     * @var array
     */
    public static $update_profile_rules = [
        'name' => 'required|max:255',
        'email' => 'required|max:255|email|unique:users,email',
    ];

    /**
     * Validation rules labels
     *
     * @var array
     */
    public static $rules_labels = [
        'name' => 'Nome',
        'email' => 'E-mail',
        'password' => 'Senha',
        'current_password' => 'Senha Atual',
    ];

    /**
     * @param string $password
     * @return void
     **/
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function posts()
    {
        return $this->hasMany(\App\Models\Post::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function comments()
    {
        return $this->hasMany(\App\Models\Comment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function transactions()
    {
        return $this->hasMany(\App\Models\Transaction::class);
    }
}
