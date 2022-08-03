<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\{RegisterRequest, VerifyAccountRequest};
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request, User $user)
    {
        $user->fill($request->validated()+['verified_code' => 1111])->save();
        return response()->json([
            'status' => true,
            'data' => [
                'mask_phone' => str_repeat('*', 8) . substr($user->phone, -3, 3),
                'phone' => $user->phone
            ],
            'message' => __('auth.success_register_please_verify')
        ]);
    }

    public function verify(VerifyAccountRequest $request)
    {
        $user = User::where([
            'phone' => $request->phone,
            'verified_code' => $request->verified_code,
            'phone_verified_at' => null,
        ])->update(['verified_code' => null, 'phone_verified_at' => now(), 'is_active' => true]);

        return response()->json(['status' => true, 'data' => null, 'message' => __('auth.success_phone_verified_make_login')]);
    }
}
