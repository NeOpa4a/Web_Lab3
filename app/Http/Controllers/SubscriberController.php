<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Schema(
 *     schema="Subscriber",
 *     type="object",
 *     @OA\Property(property="email", type="string", format="email", example="example@example.com"),
 *     @OA\Property(property="name", type="string", example="John Doe")
 * )
 */
class SubscriberController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/subscribers",
     *     summary="Get all subscribers",
     *     @OA\Response(response="200", description="A list of subscribers")
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json(Subscriber::with('subscriptions')->paginate());
    }

    /**
     * @OA\Post(
     *     path="/api/subscribers",
     *     summary="Create a new subscriber",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Subscriber")
     *     ),
     *     @OA\Response(response="201", description="Subscriber created"),
     *     @OA\Response(response="400", description="Invalid input")
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:subscribers,email',
            'name' => 'required|string|max:255',
        ]);

        $subscriber = Subscriber::create($validated);
        return response()->json($subscriber, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/subscribers/{id}",
     *     summary="Get a specific subscriber",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response="200", description="Subscriber found"),
     *     @OA\Response(response="404", description="Subscriber not found")
     * )
     */
    public function show(Int $id)
    {
        $subscriber = Subscriber::findOrFail($id);
        return response()->json($subscriber);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subscriber $subscriber)
    {
        //
    }

    /**
     * @OA\Put(
     *     path="/api/subscribers/{id}",
     *     summary="Update a specific subscriber",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Subscriber")
     *     ),
     *     @OA\Response(response="200", description="Subscriber updated"),
     *     @OA\Response(response="404", description="Subscriber not found")
     * )
     */
    public function update(Request $request, Int $id)
    {
        $validated = $request->validate([
            'email' => 'sometimes|required|email|unique:subscribers,email,' . $id,
            'name' => 'sometimes|required|string|max:255',
        ]);

        $subscriber = Subscriber::findOrFail($id);

        $subscriber->update($validated);
        return response()->json($subscriber);
    }

    /**
     * @OA\Delete(
     *     path="/api/subscribers/{id}",
     *     summary="Delete a specific subscriber",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response="204", description="Subscriber deleted")
     * )
     */
    public function destroy(Int $id)
    {
        $subscriber = Subscriber::findOrFail($id);
        $subscriber->delete();
        return response()->json(null, 204);
    }
}
