<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use App\Models\Auth\UserAuth;

class UserAuthController extends Controller
{
    use ApiResponseHelpers;

    public function Login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            $message = $validator->errors();
            $message = str_replace(array(
                '\'', '"',
                ',', '{', '[', ']', '}'
            ), '', $message);
            return $this->respondError($message);
        } else {
            if (!Auth::attempt($request->only('username', 'password'))) {
                return $this->respondUnAuthenticated("Unauthorized, invalid login details");
            } else {
                $user = UserAuth::where('username', $request['username'])->firstOrFail();

                $token = $user->createToken('auth_token')->plainTextToken;

                return $this->respondWithSuccess(['access_token' => $token, 'token_type' => 'Bearer']);
            }
        }
    }

    public function Logout(Request $request): JsonResponse
    {
        // Revoke the token that was used to authenticate the current request...
        $request->user()->currentAccessToken()->delete();

        return $this->respondOk("You have successfully logged out");
    }
}
