<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\Comment\CreateCommentRequest;
use App\Http\Requests\API\Post\DeletePostCommentRequest;
use App\Http\Requests\API\Post\ListPostCommentRequest;
use App\Models\Post;
use App\Models\User;
use App\Transformers\CommentTransformer;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\DataArraySerializer;

class PostAPIController extends BaseAPIController
{
    /**
     * Store a newly created Comment in storage.
     * PUT posts/{post}/comments
     *
     * @param Post $post
     * @param CreateCommentRequest $createCommentRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function comment(Post $post, CreateCommentRequest $createCommentRequest)
    {
        $user = $createCommentRequest->user();
        $data = [
            'user_id' => $user->id,
            'kind' => ($createCommentRequest->get('value') > 0 ? 'paid' : 'free'),
            'priority' => ($createCommentRequest->get('value') > 0 ? 1 : 2),
            'content' => $createCommentRequest->get('content'),
            'value' => $createCommentRequest->get('value'),
        ];
        $comment = $post->comments()->create($data);

        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());
        $resource = new Item($comment, new CommentTransformer());

        return $this->sendResponse($manager->createData($resource)->toArray(), 'Comentário criado com sucesso');
    }

    /**
     * Display a listing of the Comments.
     * GET|HEAD posts/{post}/comments
     *
     * @param Post $post
     * @param ListPostCommentRequest $listCommentPostRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function comments(Post $post, ListPostCommentRequest $listCommentPostRequest)
    {
        $paginator = $post->comments()->highPriority()->valuable()->latest()->paginate(10);
        $comments = $paginator->getCollection();

        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());

        $resource = new Collection($comments, new CommentTransformer());
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        return $this->sendResponse($manager->createData($resource)->toArray(), 'Comentários listados com sucesso');
    }

    /**
     * Removes the specified Comments from storage.
     * DELETE posts/{post}/users/{user}/comments
     *
     * @param Post $post
     * @param User $user
     * @param DeletePostCommentRequest $deletePostCommentRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteUserComments(Post $post, User $user, DeletePostCommentRequest $deletePostCommentRequest)
    {
        $post->comments()->where('user_id', '=', $user->id)->delete();

        return $this->sendResponse([], 'Comentários deletado(a) com sucesso');
    }
}
