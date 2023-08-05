<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\CommentController;
use App\Http\Models\Comment;
use App\Models\Comment as ModelsComment;
use App\Models\CommentsVote;

class DeleteCommentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

protected $comment_id;
protected $obj;

    /**
     * Create a new job instance.
     */
    public function __construct($comment_id)
    {
         $this->comment_id = $comment_id;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $this->obj = new CommentsVote(); // Replace YourClassName with the actual class name

        $comment_id = ModelsComment::find($this->comment_id);

        if ($comment_id) {
            // Add your deletion logic here
            $comment_id->delete();
        }

        $comment_id = 4;
        $response = $this->obj->handleDownVote($comment_id);

        return response()->json($response);
    }

}
