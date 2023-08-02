<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
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
        $this->validate($request, [
            'nickname' => ['required', 'string', 'max:255'],
            'imei' => ['required', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8',],
            'gender' => ['required',],
            'age' => ['required'],
            'country' => ['required', 'string'],
        ]);

        $user = User::create([
            'nickname' => $request->nickname,
            'imei' => $request->imei,
            'password' => bcrypt($request->password),
            'gender' => $request->gender,
            'age' => $request->age,
            'country' => $request->country,
        ]);

        $token = $this->login($request);

        return response()->json([
            'message' => 'User created successfully',
            'token' => $token->original['token'],
            'user' => $user,
        ], 201);
    }
    /**
     * Display the specified resource.
     */
    public function login(Request $request)
    {
        $credentials = $request->only('nickname', 'imei');

        if (Auth::guard('api')->once($credentials)) {
            $user = Auth::guard('api')->user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'token' => $token,
                'user' => $user
            ]);
        }

        return response()->json([
            'message' => 'Invalid login credentials',
        ], 401);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
