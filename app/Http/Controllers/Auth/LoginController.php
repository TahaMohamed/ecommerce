<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\{LoginRequest, LogoutRequest};
use App\Http\Resources\Dashboard\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($this->getCredentials($request))) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('auth.failed')], 401);
        }
        return $this->makeLogin($request, Auth::user());
    }

    private function makeLogin($request, $user)
    {
        $user->token = $user->createToken('RaseedJakDashboard')->plainTextToken;

        return UserResource::make($user)->additional([
            'status' => true,
            'message' => trans('auth.success_login', ['user' => $user->name])
        ]);
    }

    public function logout(LogoutRequest $request)
    {
        if (auth()->check()) {
            $user = Auth::user();
            $device = $user->devices()->where(['user_id' => $user->id, 'device_token' => $request->device_token, 'device_type' => $request->device_type])->first();
            if ($device) {
                $device->delete();
            }
            $user->currentAccessToken()->delete();
            return response()->json(['status' => true, 'data' => null, 'message' => trans('auth.logout_waiting_u_another_time')]);
        }
    }


    private function getCredentials(Request $request)
    {
        $username = is_numeric($username) && strlen($username) > 6 ? 'phone' : 'email';

        return [
            $username => $request->username,
            'password' => $request->password
        ];
    }
}
