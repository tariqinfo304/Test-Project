<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Website;
use App\Models\Subscription;

class SubscriptionController extends Controller
{
    /**
     * Subscribe user to a website.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function subscribe(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'website_id' => 'required|exists:websites,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $email = $request->input('email');
        $websiteId = $request->input('website_id');

        // Check if user already subscribed to website
        $subscription = Subscription::where('email', $email)
            ->where('website_id', $websiteId)
            ->first();

        if ($subscription) {
            return response()->json(['message' => 'User already subscribed to this website.'], 200);
        }

        // Create new subscription
        $subscription = new Subscription();
        $subscription->email = $email;
        $subscription->website_id = $websiteId;
        $subscription->save();

        return response()->json(['message' => 'Subscription created successfully.'], 201);
    }
}
