<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\User\ListUserCommentRequest;
use App\Http\Requests\API\User\UpdatePasswordAPIRequest;
use App\Http\Requests\API\User\UpdateProfileAPIRequest;
use App\Models\Post;
use App\Models\User;
use App\Transformers\CommentTransformer;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\DataArraySerializer;

/**
 * Class UserController
 * @package App\Http\Controllers\API
 */
class UserAPIController extends BaseAPIController
{
    /**
     * Display a listing of the Comments.
     * GET|HEAD users/{user}/comments
     *
     * @param User $user
     * @param ListUserCommentRequest $listCommentUserRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function comments(User $user, ListUserCommentRequest $listCommentUserRequest)
    {
        $paginator = $user->comments()->highPriority()->valuable()->latest()->paginate(10);
        $comments = $paginator->getCollection();

        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());

        $resource = new Collection($comments, new CommentTransformer());
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        return $this->sendResponse($manager->createData($resource)->toArray(), 'Comentários listados com sucesso');
    }
}
