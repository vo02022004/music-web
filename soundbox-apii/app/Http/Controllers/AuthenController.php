<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class AuthenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->first();
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return response(['access_token' => $tokenResult]);
            // $request->session()->regenerate();
            // return response(['message' => 'login success'], 200);
        } else {
            return response(['message' => 'login fail'], 200);
        }

        return back()->withErrors([
            'email' => 'Tài khoản hoặc mật khẩu không chính xác.',
        ]);
    }
    public function loginBe(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = User::where('email', $request->email)->first();
            if ($user->role === 'admin') {
                return redirect('/songs/create');
            }
            return redirect('/');
        } else {
            return back()->withErrors([
                'email' => 'Tài khoản hoặc mật khẩu không chính xác.',
            ]);
        }
    }
    public function logout2()
    {
        Session::flush();
        return redirect('/');
    }
    public function logout(Request $request)
    {
        // Auth::logout();
        // Session::flush();
        $request->user()->currentAccessToken()->delete();
        return response(['message' => 'log out'], 200);
    }
    public function me(Request $request)
    {
        return response($request->user(), 200);
    }
}
