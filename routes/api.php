<?php

use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route for getting the authenticated user
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Subscribers Routes
Route::get('/subscribers', [SubscriberController::class, 'index']); // Get all subscribers
Route::post('/subscribers', [SubscriberController::class, 'store']); // Create a new subscriber
Route::get('/subscribers/{id}', [SubscriberController::class, 'show']); // Get a specific subscriber
Route::put('/subscribers/{id}', [SubscriberController::class, 'update']); // Update a specific subscriber
Route::delete('/subscribers/{id}', [SubscriberController::class, 'destroy']); // Delete a specific subscriber

// Subscriptions Routes
Route::get('/subscriptions', [SubscriptionController::class, 'index']); // Get all subscriptions
Route::post('/subscriptions', [SubscriptionController::class, 'store']); // Create a new subscription
Route::get('/subscriptions/{id}', [SubscriptionController::class, 'show']); // Get a specific subscription
Route::put('/subscriptions/{id}', [SubscriptionController::class, 'update']); // Update a specific subscription
Route::delete('/subscriptions/{id}', [SubscriptionController::class, 'destroy']); // Delete a specific subscription
