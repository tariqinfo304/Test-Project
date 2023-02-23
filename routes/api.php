<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SubscriptionController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



// create a new post for a website
Route::post('/websites/{website}/posts', [PostController::class, 'create']);

// subscribe a user to a website
Route::post('/websites/{website}/subscribe', [SubscriptionController::class, 'subscribe']);

// unsubscribe a user from a website
Route::delete('/websites/{website}/unsubscribe', [SubscriptionController::class, 'destroy']);
