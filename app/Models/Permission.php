<?php

namespace App\Models;

use Laratrust\Models\LaratrustPermission;

/**
 * Class Permission
 * @package App\Models
 *
 * @property Role roles
 * @property int id
 * @property string name
 * @property string display_name
 * @property string description
 * @property string|\Carbon\Carbon created_at
 * @property string|\Carbon\Carbon updated_at
 */
class Permission extends LaratrustPermission
{
    public $table = 'permissions';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = [];

    public $fillable = [
        'name',
        'display_name',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'display_name' => 'string',
        'description' => 'string'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function roles()
    {
        return $this->belongsToMany(\App\Models\Role::class, 'permissions_roles', 'permission_id', 'role_id');
    }
}
