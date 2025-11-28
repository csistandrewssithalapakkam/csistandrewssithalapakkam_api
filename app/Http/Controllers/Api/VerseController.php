<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Verse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VerseController extends Controller
{
    /**
     * Get verse for today/current week
     *
     * @OA\Get(
     *     path="/api/verses/today",
     *     summary="Get verse for today",
     *     tags={"Verses"},
     *     @OA\Response(
     *         response=200,
     *         description="Today's verse",
     *         @OA\JsonContent(
     *             @OA\Property(property="verse_id", type="integer"),
     *             @OA\Property(property="week_date", type="string", format="date"),
     *             @OA\Property(property="verse_tamil", type="string"),
     *             @OA\Property(property="verse_english", type="string"),
     *             @OA\Property(property="verse_status", type="string")
     *         )
     *     ),
     *     @OA\Response(response=404, description="No verse found")
     * )
     */
    public function today(): JsonResponse
    {
        $today = now()->toDateString();
        $verse = Verse::where('week_date', '<=', $today)
            ->where('verse_status', '1')
            ->orderBy('week_date', 'desc')
            ->first();

        if (!$verse) {
            return response()->json(['message' => 'No verse found for today'], 404);
        }

        return response()->json($verse);
    }

    /**
     * Get all verses
     *
     * @OA\Get(
     *     path="/api/verses",
     *     summary="Get all verses",
     *     tags={"Verses"},
     *     @OA\Response(
     *         response=200,
     *         description="List of verses",
     *         @OA\JsonContent(type="array", @OA\Items(
     *             @OA\Property(property="verse_id", type="integer"),
     *             @OA\Property(property="week_date", type="string", format="date"),
     *             @OA\Property(property="verse_tamil", type="string"),
     *             @OA\Property(property="verse_english", type="string"),
     *             @OA\Property(property="verse_status", type="string")
     *         ))
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $verses = Verse::where('verse_status', '1')
            ->orderBy('week_date', 'desc')
            ->get();

        return response()->json($verses);
    }

    /**
     * Get verse by ID
     *
     * @OA\Get(
     *     path="/api/verses/{id}",
     *     summary="Get verse by ID",
     *     tags={"Verses"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Verse details"),
     *     @OA\Response(response=404, description="Verse not found")
     * )
     */
    public function show($id): JsonResponse
    {
        $verse = Verse::find($id);

        if (!$verse) {
            return response()->json(['message' => 'Verse not found'], 404);
        }

        return response()->json($verse);
    }
}
