<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
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
        //

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'gender' => 'required',
            'password' => 'required',
        ]);
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->password = password_hash($request->password, PASSWORD_DEFAULT);

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . $avatar->getClientOriginalName();
            $avatarPath = $avatar->move(
                'uploads/avatars',
                $avatarName
            );
            $user->avatar = $avatarPath;
        }
        if ($user->save()) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $tokenResult = $user->createToken('authToken')->plainTextToken;
                return response(['access_token' => $tokenResult]);
            }
        } else {
            return response(['message' => 'add fail'], 203);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $user = User::find(($id));
        return response($user);
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
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
        ]);
        $user = User::find($id);
        if (password_verify($request->old_password, $user->password)) {
            $user->password = password_hash($request->new_password, PASSWORD_DEFAULT);
            if ($user->save()) {
                return response(['message' => 'password changed'], 200);
            }
        }
        return response(['message' => 'password invalid'], 203);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
