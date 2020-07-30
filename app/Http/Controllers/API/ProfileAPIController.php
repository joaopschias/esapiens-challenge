<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\User\UpdatePasswordAPIRequest;
use App\Http\Requests\API\User\UpdateProfileAPIRequest;
use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\DataArraySerializer;

/**
 * Class ProfileAPIController
 * @package App\Http\Controllers\API
 */
class ProfileAPIController extends BaseAPIController
{
    /**
     * Update the specified User in storage.
     * PATCH api/profile
     *
     * @param UpdateProfileAPIRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProfileAPIRequest $request)
    {
        $user = $request->user();
        $requestSanitized = $request->validated();
        $user->update($requestSanitized);

        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());
        $resource = new Item($user, new UserTransformer());

        return $this->sendResponse($manager->createData($resource)->toArray(), 'Dados atualizados com sucesso');
    }

    /**
     * Update the specified User password in storage.
     * PATCH api/profile/password
     *
     * @param UpdatePasswordAPIRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function password(UpdatePasswordAPIRequest $request)
    {
        $user = $request->user();
        $requestSanitized = $request->validated();
        $user->update($requestSanitized);

        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());
        $resource = new Item($user, new UserTransformer());

        return $this->sendResponse($manager->createData($resource)->toArray(), 'Senha atualizada com sucesso');
    }

    /**
     * Bring User Notifications from storage
     * GET|HEAD users/profile/notifications
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function notifications(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $notifications = $user->notifications()->where('created_at', '<=', now()->subHours(6))->latest()->get();

        return $this->sendResponse($notifications, 'Notificações obtidas com sucesso');
    }
}
