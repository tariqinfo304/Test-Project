<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Website;
use App\Notifications\NewPostNotification;

class SendPostEmails extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:send';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email notifications to subscribers for new posts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $websites = Website::all();

        foreach ($websites as $website) {
            $posts = $website->posts()->where('created_at', '>', $website->last_notification_sent_at)->get();

            foreach ($posts as $post) {
                $subscribers = $post->subscribers;

                foreach ($subscribers as $subscriber) {
                    Mail::to($subscriber->email)->send(new NewPostNotification($post));

                    $post->subscribers()->updateExistingPivot($subscriber->id, ['sent_at' => now()]);
                }
            }

            $website->last_notification_sent_at = now();
            $website->save();
        }
    }

}
