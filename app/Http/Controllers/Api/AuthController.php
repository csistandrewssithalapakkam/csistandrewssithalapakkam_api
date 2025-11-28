<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Register a new user
     *
     * @OA\Post(
     *     path="/api/auth/register",
     *     summary="Register a new user",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_name","user_email","user_password"},
     *             @OA\Property(property="user_name", type="string", example="John Doe"),
     *             @OA\Property(property="user_email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="user_password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="user", type="object"),
     *             @OA\Property(property="token", type="string")
     *         )
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|string|max:45',
            'user_email' => 'required|string|email|max:45|unique:tbl_user,user_email',
            'user_password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'user_name' => $request->user_name,
            'user_email' => $request->user_email,
            'user_password' => Hash::make($request->user_password),
            'user_active' => 1,
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    /**
     * Login user and get JWT token
     *
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="Login user and get JWT token",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_email","user_password"},
     *             @OA\Property(property="user_email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="user_password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="token", type="string"),
     *             @OA\Property(property="user", type="object")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Invalid credentials")
     * )
     */
    public function login(Request $request): JsonResponse
    {
        $email = $request->user_email;
        $password = $request->user_password;

        // Find user by email
        $user = User::where('user_email', $email)->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid email or password'], 401);
        }

        // Check password
        if (!Hash::check($password, $user->user_password)) {
            return response()->json(['message' => 'Invalid email or password'], 401);
        }

        // Create JWT token
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user,
        ]);
    }

    /**
     * Logout user (blacklist token)
     *
     * @OA\Post(
     *     path="/api/auth/logout",
     *     summary="Logout user",
     *     tags={"Auth"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Logout successful"),
     * )
     */
    public function logout(): JsonResponse
    {
        auth()->logout();
        return response()->json(['message' => 'Logout successful']);
    }

    /**
     * Refresh JWT token
     *
     * @OA\Post(
     *     path="/api/auth/refresh",
     *     summary="Refresh JWT token",
     *     tags={"Auth"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Token refreshed", @OA\JsonContent(
     *         @OA\Property(property="token", type="string")
     *     ))
     * )
     */
    public function refresh(): JsonResponse
    {
        return response()->json([
            'token' => auth()->refresh(),
        ]);
    }

    /**
     * Get authenticated user profile
     *
     * @OA\Get(
     *     path="/api/auth/me",
     *     summary="Get authenticated user profile",
     *     tags={"Auth"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="User profile", @OA\JsonContent(
     *         @OA\Property(property="user", type="object")
     *     ))
     * )
     */
    public function me(): JsonResponse
    {
        return response()->json(['user' => auth()->user()]);
    }
}
