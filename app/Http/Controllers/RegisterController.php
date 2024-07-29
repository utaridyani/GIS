<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $response = Http::post('https://gisapis.manpits.xyz/api/register', [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        $responseData = $response->json();

        if ($response->successful() && isset($responseData['meta']['message']) && $responseData['meta']['message'] === 'Successfully create user') {
            $userData = $responseData['meta']['data'];
    
            // success pop up
            $successMessage = isset($responseData['meta']['message']) ? $responseData['meta']['message'] : "Successfully registered user: {$userData['name']}";
            session(['success' => $successMessage]);
            return redirect()->route('login')->with(['success' => $successMessage]);
        }

        $errorMessage = isset($responseData['meta']['message']) ? $responseData['meta']['message'] : 'Registration failed. Please try again';
        session(['error' => $errorMessage]);
        return redirect()->back()->withInput()->withErrors(['error' => $errorMessage]);
    }
}
