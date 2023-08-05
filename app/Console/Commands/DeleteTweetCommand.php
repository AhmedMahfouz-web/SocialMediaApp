<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteTweetCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-tweet-command {tweet_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Tweet after 30sec';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tweet_id = $this->argument('tweet_id');

        DB::table('tweets')->where('id', $tweet_id)->delete();

        $this->info('Order deleted successfully!');
    }
}
