<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Role;

/**
 * Class RoleTransformer.
 *
 * @package namespace App\Transformers;
 */
class RoleTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'permissions',
    ];

    /**
     * Transform the Role entity.
     *
     * @param \App\Models\Role $role
     *
     * @return array
     */
    public function transform(Role $role)
    {
        return [
            'id' => (int)$role->id,
            'name' => $role->name,
            'display_name' => $role->display_name,
            'description' => $role->description,
        ];
    }

    /**
     * @param Role $role
     * @return \League\Fractal\Resource\Collection|null
     */
    public function includePermissions(Role $role)
    {
        if (!empty($role->permissions)) {
            return $this->collection($role->permissions, new PermissionTransformer());
        }
        return null;
    }
}
