<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\User;

/**
 * Class UserTransformerTransformer.
 *
 * @package namespace App\Transformers;
 */
class UserTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'roles',
    ];

    protected $availableIncludes = [
        'permissions',
    ];

    /**
     * Transform the User entity.
     *
     * @param \App\Models\User $user
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id' => (int)$user->id,
            'name' => $user->name,
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
            'deleted_at' => $user->deleted_at,
        ];
    }

    /**
     * @param \App\Models\User $user
     * @return \League\Fractal\Resource\Collection|null
     */
    public function includeRoles(User $user)
    {
        if (!empty($user->roles)) {
            return $this->collection($user->roles, new RoleTransformer());
        }
        return null;
    }

    /**
     * @param \App\Models\User $user
     * @return \League\Fractal\Resource\Collection|null
     */
    public function includePermissions(User $user)
    {
        if (!empty($user->permissions)) {
            return $this->collection($user->permissions, new PermissionTransformer());
        }
        return null;
    }
}
