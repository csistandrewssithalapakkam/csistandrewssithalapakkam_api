<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ExampleController extends Controller
{
    /**
     * Get example data
     *
     * @OA\Get(
     *     path="/api/example",
     *     summary="Get example data",
     *     tags={"Example"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Hello from API"),
     *             @OA\Property(property="timestamp", type="string", format="date-time")
     *         )
     *     )
     * )
     */
    public function example(): JsonResponse
    {
        return response()->json([
            'message' => 'Hello from API',
            'timestamp' => now(),
        ]);
    }
}
