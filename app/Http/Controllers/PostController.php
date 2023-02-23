<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Website;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller
{
    public function create(Request $request, $websiteId)
    {
        // Validate request data
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        // Create post for website
        $website = Website::findOrFail($websiteId);
        $post = $website->posts()->create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        // Send email notifications to subscribers
        $this->sendEmailNotifications($website, $post);

        // Return success response
        return response()->json([
            'message' => 'Post created successfully.',
            'post' => $post,
        ], 201);
    }

    public function subscribe(Request $request, $websiteId)
    {
        // Validate request data
        $request->validate([
            'email' => 'required|email',
        ]);

        // Find website
        $website = Website::findOrFail($websiteId);

        // Create subscription
        $subscription = new Subscription([
            'email' => $request->input('email'),
        ]);
        $website->subscriptions()->save($subscription);

        // Return success response
        return response()->json([
            'message' => 'Subscribed successfully.',
            'subscription' => $subscription,
        ], 201);
    }

    protected function sendEmailNotifications(Website $website, Post $post)
    {
        $subscribers = $website->subscriptions;
        foreach ($subscribers as $subscriber) {
            // Check if subscriber has already received this post
            $hasReceivedPost = $subscriber->posts()->where('post_id', $post->id)->exists();
            if (!$hasReceivedPost) {
                // Send email to subscriber
                Mail::to($subscriber->email)->send(new NewPostNotification($post));

                // Create record of post being sent to subscriber
                $subscriber->posts()->attach($post->id);
            }
        }
    }
}
