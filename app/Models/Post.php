<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

/**
 * Class Post
 * @package App\Models
 *
 * @property User user
 * @property Comment comments
 * @property Transaction transactions
 * @property int id
 * @property int user_id
 * @property string kind
 * @property string content
 * @property string|\Carbon\Carbon created_at
 * @property string|\Carbon\Carbon updated_at
 * @property string|\Carbon\Carbon deleted_at
 */
class Post extends Model
{
    use SoftDeletes;

    protected $dates = [
        'deleted_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'kind',
        'content',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'kind' => 'string',
        'content' => 'string',
    ];

    /**
     * Regras para Register do App
     *
     * @var array
     */
    public static $standard_rules = [
        'user_id' => 'required|exists:users,id',
        'kind' => 'required',
        'content' => 'required',
    ];

    /**
     * Validation rules labels
     *
     * @var array
     */
    public static $rules_labels = [
        'user_id' => 'Usuário',
        'kind' => 'Tipo',
        'content' => 'Conteúdo',
    ];

    /**
     * @var array
     */
    protected static $_kinds = [
        'photo' => 'Foto',
        'video' => 'Vídeo',
        'text' => 'Texto',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
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

    /**
     * @return array
     */
    public static function getArrayKinds()
    {
        return static::$_kinds;
    }

    /**
     * @return array|string
     */
    public function getKind()
    {
        return Arr::get(static::$_kinds, $this->kind, null);
    }
}
