<?php

namespace App\Http\Controllers;

use App\Modules\User\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function landingPage(){
        return redirect('/login');
    }
    public function authenticate(Request $request)
    {
        if(Auth::user())
        {
            return redirect('/home');
        }

        $credentials = $request->only(['email', 'password']);

        $this->guard()->setTTL(720);
        if (!$token = $this->guard()->attempt($credentials)){
            return redirect('/login')->with('message', 'Incorrect email or password');
        }

        $cookie = \Cookie::make('token', $token, '3600');
        return redirect('/home')->withCookie($cookie);
    }

    protected function respondWithToken($token)
    {
      return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => auth()->factory()->getTTL() * 60
      ]);
    }

    public function logout(Request $request)
    {
        $cookie = \Cookie::forget('token');
        return redirect('/login')->withCookie($cookie);
    }

    public function guard()
    {
        return Auth::guard();
    }

    public function refresh()
    {
        $token = $this->guard()->refresh();
        $cookie = \Cookie::make('token', $token);
        return redirect('/home')->withCookie($cookie);
    }
}
