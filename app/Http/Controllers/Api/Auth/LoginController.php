<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\{LoginRequest, LogoutRequest};
use App\Http\Resources\Api\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($this->getCredentials($request))) {
            return response()->json(['status' => false, 'data' => null, 'message' => __('auth.failed')], 401);
        }
        return $this->makeLogin($request, Auth::user());
    }

    private function makeLogin($request, $user)
    {
        if ($request->has('device_token','device_type')) {
            $user->devices()->firstOrCreate($request->only(['device_token','device_type']));
        }
        $user->token = $user->createToken('RaseedJakDashboard')->plainTextToken;
        return UserResource::make($user)->additional([
            'status' => true,
            'message' => __('auth.success_login', ['user' => $user->name])
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
            return response()->json(['status' => true, 'data' => null, 'message' => __('auth.logout_waiting_u_another_time')]);
        }
    }


    private function getCredentials(Request $request)
    {
        $username = is_numeric($request->username) && strlen($request->username) > 6 ? 'phone' : 'email';

        return [
            $username => $request->username,
            'password' => $request->password
        ];
    }
}
