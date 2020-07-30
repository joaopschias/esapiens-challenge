<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

/**
 * Class Transaction
 * @package App\Models
 *
 * @property User user
 * @property Post post
 * @property Comment comment
 * @property int id
 * @property int user_id
 * @property int post_id
 * @property int comment_id
 * @property string kind
 * @property float value
 * @property string|\Carbon\Carbon created_at
 * @property string|\Carbon\Carbon updated_at
 * @property string|\Carbon\Carbon deleted_at
 */
class Transaction extends Model
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
        'post_id',
        'comment_id',
        'kind',
        'value',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'post_id' => 'integer',
        'comment_id' => 'integer',
        'kind' => 'string',
        'value' => 'float',
    ];

    /**
     * Regras para Register do App
     *
     * @var array
     */
    public static $standard_rules = [
        'user_id' => 'required|exists:users,id',
        'post_id' => 'required|exists:posts,id',
        'comment_id' => 'required|exists:comments,id',
        'kind' => 'required',
        'value' => 'required|numeric',
    ];

    /**
     * Validation rules labels
     *
     * @var array
     */
    public static $rules_labels = [
        'user_id' => 'Usuário',
        'post_id' => 'Postagem',
        'comment_id' => 'Comentário',
        'kind' => 'Tipo',
        'value' => 'Valor',
    ];

    /**
     * @var array
     */
    protected static $_kinds = [
        'charge' => 'Cobrança',
        'retention' => 'Retenção do Sistema',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function post()
    {
        return $this->belongsTo(\App\Models\Post::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function comment()
    {
        return $this->belongsTo(\App\Models\Comment::class);
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
