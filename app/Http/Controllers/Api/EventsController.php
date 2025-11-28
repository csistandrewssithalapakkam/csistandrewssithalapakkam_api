<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Birthday;
use App\Models\WeddingAnniversary;
use Illuminate\Http\JsonResponse;

class EventsController extends Controller
{
    /**
     * Get today's birthdays
     *
     * @OA\Get(
     *     path="/api/events/birthdays/today",
     *     summary="Get today's birthdays",
     *     tags={"Events"},
     *     @OA\Response(
     *         response=200,
     *         description="List of today's birthdays",
     *         @OA\JsonContent(type="array", @OA\Items(
     *             @OA\Property(property="bd_id", type="integer"),
     *             @OA\Property(property="bd_member_id", type="integer"),
     *             @OA\Property(property="bd_date", type="string", format="date"),
     *             @OA\Property(property="member", type="object")
     *         ))
     *     )
     * )
     */
    public function birthdaysToday(): JsonResponse
    {
        $today = now()->format('m-d');
        $birthdays = Birthday::whereRaw("DATE_FORMAT(bd_date, '%m-%d') = ?", [$today])
            ->with('member')
            ->get();

        return response()->json($birthdays);
    }

    /**
     * Get upcoming birthdays (next 30 days)
     *
     * @OA\Get(
     *     path="/api/events/birthdays/upcoming",
     *     summary="Get upcoming birthdays (next 30 days)",
     *     tags={"Events"},
     *     @OA\Response(
     *         response=200,
     *         description="List of upcoming birthdays"
     *     )
     * )
     */
    public function birthdaysUpcoming(): JsonResponse
    {
        $today = now();
        $endDate = now()->addDays(30);

        $birthdays = Birthday::whereBetween('bd_date', [$today->toDateString(), $endDate->toDateString()])
            ->with('member')
            ->orderBy('bd_date', 'asc')
            ->get();

        return response()->json($birthdays);
    }

    /**
     * Get all birthdays
     *
     * @OA\Get(
     *     path="/api/events/birthdays",
     *     summary="Get all birthdays",
     *     tags={"Events"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all birthdays"
     *     )
     * )
     */
    public function allBirthdays(): JsonResponse
    {
        $birthdays = Birthday::with('member')->orderBy('bd_date', 'asc')->get();
        return response()->json($birthdays);
    }

    /**
     * Get today's anniversaries
     *
     * @OA\Get(
     *     path="/api/events/anniversaries/today",
     *     summary="Get today's anniversaries",
     *     tags={"Events"},
     *     @OA\Response(
     *         response=200,
     *         description="List of today's anniversaries"
     *     )
     * )
     */
    public function anniversariesToday(): JsonResponse
    {
        $today = now()->format('m-d');
        $anniversaries = WeddingAnniversary::whereRaw("DATE_FORMAT(wa_date, '%m-%d') = ?", [$today])
            ->with('member1', 'member2')
            ->get();

        return response()->json($anniversaries);
    }

    /**
     * Get upcoming anniversaries (next 30 days)
     *
     * @OA\Get(
     *     path="/api/events/anniversaries/upcoming",
     *     summary="Get upcoming anniversaries (next 30 days)",
     *     tags={"Events"},
     *     @OA\Response(
     *         response=200,
     *         description="List of upcoming anniversaries"
     *     )
     * )
     */
    public function anniversariesUpcoming(): JsonResponse
    {
        $today = now();
        $endDate = now()->addDays(30);

        $anniversaries = WeddingAnniversary::whereBetween('wa_date', [$today->toDateString(), $endDate->toDateString()])
            ->with('member1', 'member2')
            ->orderBy('wa_date', 'asc')
            ->get();

        return response()->json($anniversaries);
    }

    /**
     * Get all anniversaries
     *
     * @OA\Get(
     *     path="/api/events/anniversaries",
     *     summary="Get all anniversaries",
     *     tags={"Events"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all anniversaries"
     *     )
     * )
     */
    public function allAnniversaries(): JsonResponse
    {
        $anniversaries = WeddingAnniversary::with('member1', 'member2')
            ->orderBy('wa_date', 'asc')
            ->get();
        return response()->json($anniversaries);
    }
}
