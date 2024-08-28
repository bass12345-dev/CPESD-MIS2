<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\LoginRequest;
use Illuminate\Http\Request;
use App\Services\user\UserService;
class AuthController extends Controller
{   
    protected $UserService;
    public function __construct(UserService $UserService){
        $this->UserService = $UserService;
    }

    public function verify_user(LoginRequest $request)
    {
           $validatedData = $request->validated();
           $user = $this->UserService->LoginUser($validatedData);


           if ($user) {
            // Registration successful
            return response()->json($user, 201);
        }
        // Handle registration failure
        return response()->json([
            'message' => 'Login Failed...'
        ], 422);      
    }


    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }
}