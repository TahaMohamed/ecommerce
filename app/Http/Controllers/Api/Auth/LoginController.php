<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\{LoginRequest, LogoutRequest};
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $this->getCredentials($request);
        if($credentials instanceof Response){
            return $credentials;
        }
        if (!Auth::attempt($credentials)) {
            return response()->json(['status' => false, 'data' => null, 'message' => __('auth.failed')], 400);
        }
        return $this->makeLogin($request, Auth::user());
    }

    private function makeLogin($request, $user)
    {
        if ($request->has('device_token','device_type')) {
            $user->devices()->firstOrCreate($request->only(['device_token','device_type']));
        }
        $user->token = $user->createToken('RaseedJakDashboard')->plainTextToken;
        return UserResource::make($user->load('store'))->additional([
            'status' => true,
            'message' => __('auth.success_login', ['user' => $user->name])
        ]);
    }

    public function logout(LogoutRequest $request)
    {
        $user = Auth::user();
        $device = $user->devices()->where(['user_id' => $user->id, 'device_token' => $request->device_token, 'device_type' => $request->device_type])->first();
        if ($device) {
            $device->delete();
        }
        $user->currentAccessToken()->delete();
        return response()->json(['status' => true, 'data' => null, 'message' => __('auth.logout_waiting_u_another_time')]);
        
    }


    private function getCredentials(Request $request)
    {
        $username = is_numeric($request->username) && strlen($request->username) > 6 ? 'phone' : 'email';
        $user = User::firstWhere($username, $request->username);
        if (! $user?->is_active) {
            $user->update(['verified_code' => 1111]);
            return response()->json([
              'status' => false,
              'data' => null,
              'message' => __('auth.account_deactive')
            ], 400);
        } elseif ($user?->is_ban) {
            return response()->json([
              'status' => false,
              'data' => null,
              'message' => __('auth.account_banned_for', ['reason' => $user->ban_reason])
            ], 403);
        }

        return [
            $username => $request->username,
            'password' => $request->password
        ];
    }
}
