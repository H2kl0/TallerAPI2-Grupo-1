<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Session::has('token'))
        {
            return redirect()->route('index');
        }
        
        return view('auth.login');
    }


    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $response = Http::acceptJson()->post('https://dummyjson.com/auth/login', [
            'username' => $request->username,
            'password' => $request->password,
            'expiresInMins' => 60
        ]);

        if($response->status() == Response::HTTP_OK)
        {
            $jsonResponse = json_decode($response->body());
            Session::put('user', $jsonResponse);
            Session::put('token', $jsonResponse->accessToken);
            Session::put('refreshToken', $jsonResponse->refreshToken);
            
            return redirect()->route('recipe.index')->with('message', '¡Bienvenido de vuelta, ' . $jsonResponse->firstName . '!');
        }
        else
        {
            return back()->withErrors([
                'username' => 'Credenciales incorrectas. Intenta con: emilys / emilyspass'
            ])->onlyInput('username'); 
        }          
    }


    /**
     * cerrar sesión del usuario
     */
    public function logout(Request $request)
    {
        if(Session::has('token'))
        {
            Session::flush();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('auth.index')->with('message', 'Sesión cerrada exitosamente');
        }
        else
        {
            return redirect()->route('auth.index')->with('warning', 'No has iniciado una sesión');
        }
    }
}
