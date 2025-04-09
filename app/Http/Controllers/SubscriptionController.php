<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

/**
 * @OA\Info(title="Subscription API", version="1.0")
 * @OA\Schema(
 *     schema="Subscription",
 *     type="object",
 *     @OA\Property(property="service", type="string", example="Email Service"),
 *     @OA\Property(property="topic", type="string", example="Newsletter"),
 *     @OA\Property(property="payload", type="object", example={"key": "value"}),
 *     @OA\Property(property="expired_at", type="string", format="date-time", example="2025-03-13T13:31:23.069Z"),
 *     @OA\Property(property="subscriber_id", type="integer", example="1")
 * )
 */
class SubscriptionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/subscriptions",
     *     summary="Get all subscriptions",
     *     @OA\Response(response="200", description="A list of subscriptions")
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json(Subscription::paginate());
    }

    /**
     * @OA\Post(
     *     path="/api/subscriptions",
     *     summary="Create a new subscription",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Subscription")
     *     ),
     *     @OA\Response(response="201", description="Subscription created"),
     *     @OA\Response(response="400", description="Invalid input")
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'service' => 'required|string|max:255',
            'topic' => 'required|string|max:255',
            'payload' => 'required|array',
            'expired_at' => 'nullable|date',
            'subscriber_id' => 'required|exists:subscribers,id'
        ]);

        $validated['payload'] = json_encode($validated['payload']);

        $subscription = Subscription::create($validated);
        return response()->json($subscription, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/subscriptions/{id}",
     *     summary="Get a specific subscription",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response="200", description="Subscription found"),
     *     @OA\Response(response="404", description="Subscription not found")
     * )
     */
    public function show(Int $id): JsonResponse
    {
        $subscription = Subscription::findOrFail($id);
        return response()->json($subscription);
    }

    /**
     * @OA\Put(
     *     path="/api/subscriptions/{id}",
     *     summary="Update a specific subscription",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Subscription")
     *     ),
     *     @OA\Response(response="200", description="Subscription updated"),
     *     @OA\Response(response="404", description="Subscription not found")
     * )
     */
    public function update(Request $request, Int $id): JsonResponse
    {
        $validated = $request->validate([
            'service' => 'sometimes|string|max:255',
            'topic' => 'sometimes|string|max:255',
            'payload' => 'sometimes|array',
            'expired_at' => 'nullable|date',
        ]);

        $subscription = Subscription::findOrFail($id);

        $subscription->update($validated);
        return response()->json($subscription);
    }

    /**
     * @OA\Delete(
     *     path="/api/subscriptions/{id}",
     *     summary="Delete a specific subscription",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response="204", description="Subscription deleted")
     * )
     */
    public function destroy(Int $id): JsonResponse
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->delete();
        return response()->json(null, 204);
    }
}
