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

            return redirect()->intended('/region-dashboard');
        }

        $errorMessage = isset($responseData['meta']['message']) ? $responseData['meta']['message'] : 'Registration failed. Please try again';
        session(['error' => $errorMessage]);
        return redirect()->back()->withInput()->withErrors(['error' => $errorMessage]);
    }
}
