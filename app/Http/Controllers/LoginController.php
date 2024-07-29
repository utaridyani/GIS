<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $response = Http::post('https://gisapis.manpits.xyz/api/login', [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        if ($response->successful()) {
            $responseData = $response->json();

            $token = $responseData['meta']['token'];

            session(['token' => $token]);

            $userIdentity = Http::withHeaders([
                'Authorization' => 'Bearer ' . session('token'),
            ])->get('https://gisapis.manpits.xyz/api/user');
            
            if ($userIdentity->successful()) {
                session()->put('userName', $userIdentity['data']['user']['name']);
            }

            return redirect()->intended('/master');
        }

        $errorMessage = isset($responseData['meta']['message']) ? $responseData['meta']['message'] : 'Registration failed. Please try again';
        session(['error' => $errorMessage]);
        return redirect()->back()->withInput()->withErrors(['error' => $errorMessage]);
    }

    public function logout(Request $request)
    {
        $token = session('token');

        $response = Http::withToken($token)
            ->post('https://gisapis.manpits.xyz/api/logout');

        if ($response->successful()) {
            // forget token
            $request->session()->forget('token');

            return view('auth.login');
        } else {
            abort(500, 'API request failed');
        }
    }
}
