<?php

namespace App\Http\Controllers\Api;

use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Libraries\ResponseBase;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|string|exists:users,email',
            'password' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return ResponseBase::error($validator->errors(), 422);
        
        $credentials = $request->only('email', 'password');
        
        if (!$token = JWTAuth::attempt($credentials))
            return ResponseBase::error("Password salah", 403);
        
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
            return ResponseBase::error('Gagal register!', 409);
        }
    }

    public function logout()
    {
        JWTAuth::invalidate();

        return ResponseBase::success('Logout berhasil');
    }
}
