<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Api\UserResource;
use Illuminate\Support\Facades\Response;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Requests\Api\ApiLoginRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class AccessApiTokensController extends Controller
{
    /**
     * Summary of store
     * @param \App\Http\Requests\Api\ApiLoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ApiLoginRequest $request): JsonResponse
    {
        $user = User::where("email", $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            $device_name = $request->post("device_name", $request->userAgent());
            $token = $user->createToken($device_name);

            return Response::json([
                'token' => $token->plainTextToken,
                'user'  => UserResource::make($user),
            ], HttpFoundationResponse::HTTP_CREATED);
        }
        return Response::json([
            'error' => 'Invaild user or password'
        ], HttpFoundationResponse::HTTP_UNAUTHORIZED);
    }

    public function destroy($token = null)
    {
        $user = Auth::guard('sanctum')->user();

        if (null == $token) {
            $user->currentAccessToken->delete();
            return response()->json([
                'message'   => "You are logged out"
            ], HttpFoundationResponse::HTTP_NO_CONTENT);
        }
        $personalAccessToken = PersonalAccessToken::findToken($token);
        if (null == $personalAccessToken) {
            $user->tokens()->delete();
            return response()->json([
                'message'   => "You are logged out"
            ], HttpFoundationResponse::HTTP_NO_CONTENT);
        }
        if (
            $user->id == $personalAccessToken->tokenable_id
            && get_class($user) == $personalAccessToken->tokenable_type
        ) {
            $personalAccessToken->delete();
            return response()->json([
                'message'   => "You are logged out successfully"
            ], HttpFoundationResponse::HTTP_OK);
        }
    }
}
