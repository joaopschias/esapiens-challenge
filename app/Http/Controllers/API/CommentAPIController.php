<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\Comment\CreateCommentRequest;
use App\Http\Requests\API\Comment\DeleteCommentRequest;
use App\Models\Comment;
use App\Models\Post;

class CommentAPIController extends BaseAPIController
{
    /**
     * Remove the specified Comment from storage.
     * DELETE /comments/{comment}
     *
     * @param Comment $comment
     * @param DeleteCommentRequest $commentRequest
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Comment $comment, DeleteCommentRequest $commentRequest)
    {
        $comment->delete();

        return $this->sendResponse([], 'Comentário deletado(a) com sucesso');
    }
}
