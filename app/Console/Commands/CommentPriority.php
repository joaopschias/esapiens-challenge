<?php

namespace App\Console\Commands;

use App\Models\Comment;
use Illuminate\Console\Command;

class CommentPriority extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'comment:priority';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $comments = Comment::query()->where('priority', '=', 1)->where('value', '>', 0)->get();
        foreach ($comments as $comment) {
            if($comment->created_at->addMinutes($comment->value)->lessThan(now())){
                $comment->priority = 2;
                $comment->save();
            }
        }
    }
}
