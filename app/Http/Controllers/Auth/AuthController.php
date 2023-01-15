<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as Status;
use App\Http\Controllers\Controller;

class AuthController extends Controller {
    public function login(LoginRequest $request ): JsonResponse
	{
        $user = User::where( 'email', $request[ 'email' ] )->first();
        // Check password
        if ( !$user || !Hash::check( $request[ 'password' ], $user->password ) ) {
            return response( [
                'message' => 'Bad creds'
            ], Status::HTTP_UNAUTHORIZED );
        }
        $token = $user->createToken(config('sanctum.token'))->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response()->json(['data'=>$response],Status::HTTP_OK);
    }

    public function logout( Request $request ):JsonResponse
	{
        auth()->user()->tokens()->delete();
        return response()->json(['message'=>'Logged Out Successfully'],Status::HTTP_OK);
    }
}
