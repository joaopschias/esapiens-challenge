<?php


namespace App\Models;

use Laratrust\Models\LaratrustRole;

/**
 * Class Role
 * @package App\Models
 *
 * @property Permission permissions
 * @property int id
 * @property string name
 * @property string display_name
 * @property string description
 * @property string|\Carbon\Carbon created_at
 * @property string|\Carbon\Carbon updated_at
 */
class Role extends LaratrustRole
{
    public $table = 'roles';

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
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'string',
        'display_name' => 'required|string|max:50|unique:role',
        'description' => 'string|max:255',
        'permissions' => 'required|array'
    ];

    /**
     * Validation rules labels
     *
     * @var array
     */
    public static $rules_labels = [
        'name' => 'Nome',
        'display_name' => 'Nome de Exibição',
        'description' => 'Descrição',
        'permissions' => 'Permissões'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function permissions()
    {
        return $this->belongsToMany(\App\Models\Permission::class, 'permissions_roles');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'roles_users');
    }
}
