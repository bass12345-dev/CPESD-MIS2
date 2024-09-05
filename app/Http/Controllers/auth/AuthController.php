<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\LoginRequest;
use App\Http\Requests\auth\RegisterUserRequest;
use App\Repositories\CustomRepository;
use Illuminate\Http\Request;
use App\Services\user\UserService;

class AuthController extends Controller
{
    protected $UserService;
    protected $customRepository;
    protected $conn;
    public function __construct(UserService $UserService, CustomRepository $customRepository)
    {
        $this->UserService = $UserService;
        $this->customRepository = $customRepository;
        $this->conn = config('custom_config.database.users');
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


    public function register_user(RegisterUserRequest $request)
    {
        $validatedData = $request->validated();
        $user = $this->UserService->registerUser($validatedData);
        if ($user) {
            // Registration successful
            return response()->json([
                'message' => 'User Registered Successfully | Please wait for Activation',
                'response' => true
            ], 201);
        }
        // Handle registration failure
        return response()->json([
            'message' => 'User registration failed. Email exists.'
        ], 422);
    }


    public function update_profile(Request $request)
    {
        $items = array(
            'first_name'        => $request->input('first_name'),
            'last_name'         => $request->input('last_name'),
            'middle_name'       => $request->input('middle_name'),
            'extension'         => $request->input('extension'),
            'address'           => $request->input('address'),
            'contact_number'    => $request->input('contact_number'),
            'email_address'     => $request->input('email'),
        );
        $where = array('user_id' => $request->input('id'));
        $update     = $this->customRepository->update_item($this->conn, 'users', $where, $items);
        if ($update) {
            $data = array('message' => 'Updated Successfully', 'response' => true);
        } else {
            $data = array('message' => 'Something Wrong/No Changes Apply', 'response' => false);
        }
        return response()->json($data);
    }

    public function check_password(Request $request)
    {
        $password = $request->input('old_password');
        $id = session('user_id');

        $user = $this->customRepository->q_get_where($this->conn, array('user_id' => $id), 'users');

        if ($user->count() > 0) {

            $check = password_verify($password, $user->first()->password);

            if ($check) {

                return response()->json(['message' => 'Success.', 'response' => true]);
            } else {
                return response()->json(['message' => 'invalid Password.', 'response' => false]);
            }
        } else {

            return response()->json(['message' => 'Invalid Username.', 'response' => false]);
        }
    }

    public function update_password(Request $request)
    {

        $password = $request->input('new_password');
        $confirm_password = $request->input('confirm_new_password');

        if ($password == $confirm_password) {

            if (strlen($password) >= 5) {

                $where = array('user_id' => session('user_id'));
                $items = array('password' =>  password_hash($password, PASSWORD_DEFAULT));
                $update     = $this->customRepository->update_item($this->conn,'users', $where, $items);
                if ($update) {
                    $data = array('message' => 'Updated Successfully', 'response' => true);
                } else {
                    $data = array('message' => 'Something Wrong/No Changes Apply', 'response' => false);
                }
            } else {
                $data = array('message' => 'Password is too short', 'response' => false);
            }
        } else {
            $data = array('message' => "Password Don't Match", 'response' => false);
        }


        return response()->json($data);
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }
}
