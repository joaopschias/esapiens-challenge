<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Comment;

/**
 * Class CommentTransformer.
 *
 * @package namespace App\Transformers;
 */
class CommentTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'user',
    ];

    /**
     * Transform the User entity.
     *
     * @param Comment $comment
     * @return array
     */
    public function transform(Comment $comment)
    {
        return [
            'id' => (int)$comment->id,
            'user_id' => (int)$comment->user_id,
            'priority' => (int)$comment->priority,
            'content' => $comment->content,
            'created_at' => $comment->created_at,
            'updated_at' => $comment->updated_at,
            'deleted_at' => $comment->deleted_at,
        ];
    }

    public function includeUser(Comment $comment)
    {
        if (!empty($comment->user)) {
            return $this->item($comment->user, new UserTransformer());
        }
        return null;
    }
}
