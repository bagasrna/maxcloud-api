<?php

namespace App\Http\Controllers\Api;

use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Libraries\ResponseBase;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|string',
            'password' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return ResponseBase::error($validator->errors(), 422);

        $credentials = $request->only('email', 'password');
        
        $token = request()->routeIs('auth.user') ? Auth::guard('user')->attempt($credentials) : Auth::guard('admin')->attempt($credentials);
        if (!$token)
            return ResponseBase::error("Email atau Password salah", 403);

        return ResponseBase::success('Login berhasil', ['token' => $token, 'type' => 'bearer']);
    }

    public function register(Request $request)
    {
        $rules = [
            'fullname' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
            'phone' => 'required|numeric|starts_with:62|min:5',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return ResponseBase::error($validator->errors(), 422);

        try {
            $user = new User();
            $user->fullname = $request->fullname;
            $user->address = $request->filled('address') ? $request->address : null;
            $user->email = strtolower($request->email);
            $user->password = bcrypt($request->password);
            $user->phone = $request->phone;
            $user->save();

            return ResponseBase::success("Berhasil register!", $user);
        } catch (\Exception $e) {
            Log::error('Gagal register: ' . $e->getMessage());
            return ResponseBase::error('Gagal register!', 409);
        }
    }

    public function getProfile()
    {
        $user = request()->routeIs('auth.profile.user') ? Auth::guard('user')->user() : Auth::guard('admin')->user();

        return ResponseBase::success('Berhasil mendapatkan data profile', ['user' => $user]);
    }

    public function logout()
    {
        JWTAuth::invalidate();

        return ResponseBase::success('Logout berhasil');
    }
}
