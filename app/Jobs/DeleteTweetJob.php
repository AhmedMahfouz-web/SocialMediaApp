<?php

namespace App\Jobs;

use App\Models\Tweet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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

        if ($tweet) {
            // Add your deletion logic here
            $tweet->delete();
        }
    }
}
