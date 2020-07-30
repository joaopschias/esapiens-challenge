<?php

namespace App\Observers;

use App\Models\Comment;
use App\Notifications\CommentCreated;

class CommentObserver
{
    /**
     * Handle the comment "created" event.
     *
     * @param \App\Models\Comment $comment
     * @return void
     */
    public function created(Comment $comment)
    {
        if ($comment->value > 0) {
            $user = $comment->user;
            $total = $comment->value;
            $charge = $total * 0.8;
            $retention = $total * 0.2;

            $comment->transactions()->createMany([
                [
                    'user_id' => $user->id,
                    'post_id' => $comment->post_id,
                    'kind' => 'charge',
                    'value' => $charge,
                ],
                [
                    'user_id' => $comment->user_id,
                    'post_id' => $comment->post_id,
                    'kind' => 'retention',
                    'value' => $retention,
                ],
            ]);

            $user->balance = ($user->balance - $total);
            $user->save();
        }

        if (!empty($comment->user) and !empty($comment->post) and !empty($comment->post->user)) {
            $comment->post->user->notify(new CommentCreated($comment->post, $comment->user));
        }
    }

    /**
     * Handle the comment "updated" event.
     *
     * @param \App\Models\Comment $comment
     * @return void
     */
    public function updated(Comment $comment)
    {
        //
    }

    /**
     * Handle the comment "deleted" event.
     *
     * @param \App\Models\Comment $comment
     * @return void
     */
    public function deleted(Comment $comment)
    {
        //
    }

    /**
     * Handle the comment "restored" event.
     *
     * @param \App\Models\Comment $comment
     * @return void
     */
    public function restored(Comment $comment)
    {
        //
    }

    /**
     * Handle the comment "force deleted" event.
     *
     * @param \App\Models\Comment $comment
     * @return void
     */
    public function forceDeleted(Comment $comment)
    {
        //
    }
}
