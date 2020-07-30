<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

/**
 * Class Comment
 * @package App\Models
 *
 * @property User user
 * @property Post post
 * @property Transaction transactions
 * @property int id
 * @property int user_id
 * @property int post_id
 * @property string kind
 * @property int priority
 * @property string content
 * @property float value
 * @property string|\Carbon\Carbon created_at
 * @property string|\Carbon\Carbon updated_at
 * @property string|\Carbon\Carbon deleted_at
 */
class Comment extends Model
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
        'kind',
        'priority',
        'content',
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
        'kind' => 'string',
        'priority' => 'integer',
        'content' => 'string',
        'value' => 'float',
    ];

    /**
     * Regras para Register do App
     *
     * @var array
     */
    public static $standard_rules = [
        'content' => 'required|min:10',
        'value' => 'numeric|min:0',
    ];

    /**
     * Validation rules labels
     *
     * @var array
     */
    public static $rules_labels = [
        'content' => 'Conteúdo',
        'value' => 'Valor',
    ];

    /**
     * @var array
     */
    protected static $_kinds = [
        'free' => 'Grátis',
        'paid' => 'Pago',
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function transactions()
    {
        return $this->hasMany(\App\Models\Transaction::class);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeHighPriority($query)
    {
        return $query->orderBy('priority', 'ASC');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeValuable($query)
    {
        return $query->orderBy('value', 'DESC');
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
