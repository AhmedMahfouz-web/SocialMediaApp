<?php

namespace App\Jobs;

use App\Models\Comment;
use App\Models\Tweet;
use App\Models\TweetsVote;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;


class DeleteTweetJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tweet_id;

    /**
     * Create a new job instance.
     */
    public function __construct($tweet_id)
    {
        $this->tweet_id = $tweet_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $tweet = Tweet::find($this->tweet_id);
        $votes = TweetsVote::where('tweet_id', $this->tweet_id)->latest()->get();
        $comments = Comment::where('tweet_id', $this->tweet_id)->with('votes')->get();

            if ($tweet) {
                $vote_up = 0;
                $vote_down = 0;
                foreach ($votes as $vote) {
                    $vote->type == 'up' ? $vote_up += 1 : $vote_down += 1;
                }
                if ($vote_down != 0) {
                    if ($vote_up / $vote_down < 1 / 3 && $vote_up / $vote_down != 0) {
                    foreach ($votes as $vote) {
                        $vote->delete();
                    }

                    foreach ($comments as $comment) {
                        foreach ($comment->vote as $comment_vote) {
                            $comment_vote->delete();
                        }
                        if (File::exists(public_path($comment->file))) {
                            File::delete(public_path($comment->file));
                        }
                        $comment->delete();
                    }

                    if (File::exists(public_path($tweet->file))) {
                        File::delete(public_path($tweet->file));
                    }
                    $tweet->delete();
                } elseif ($vote_up == 0 && $vote_down > 2) {
                    foreach ($votes as $vote) {
                        $vote->delete();
                    }

                    foreach ($comments as $comment) {
                        foreach ($comment->vote as $comment_vote) {
                            $comment_vote->delete();
                        }
                        if (File::exists(public_path($comment->file))) {
                            File::delete(public_path($comment->file));
                        }
                        $comment->delete();
                    }

                    if (File::exists(public_path($tweet->file))) {
                        File::delete(public_path($tweet->file));
                    }
                    $tweet->delete();
                }
            }
        }
    }
}
