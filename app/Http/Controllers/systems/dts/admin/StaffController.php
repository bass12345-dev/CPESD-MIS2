<?php

namespace App\Http\Controllers\systems\dts\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Services\dts\admin\DashboardService;
use App\Services\user\UserService;
use Carbon\Carbon;

class StaffController extends Controller
{
    protected $conn;
    protected $conn_dts;

    protected $customRepository;
    protected $dashboardService;
    protected $userService;
    public function __construct(CustomRepository $customRepository, DashboardService $dashboardService, UserService $userService){
        $this->conn                 = config('custom_config.database.users');
        $this->conn_dts                 = config('custom_config.database.dts');
        $this->customRepository     = $customRepository;
        $this->dashboardService     = $dashboardService;
        $this->userService          = $userService;
     
    }
    public function index(){
        $data['title']      = 'Manage Staff';
        $data['users']      = $this->customRepository->q_get_where($this->conn, array('user_status' => 'active'), 'users')->get();
        return view('systems.dts.admin.pages.manage_staff.manage_staff')->with($data);
    }

    public function get_current_receiver(){
        $row = $this->customRepository->q_get_where($this->conn, array('is_receiver' => 'yes'),'users')->first();
        $data = array(
                        'full_name' => $this->userService->user_full_name($row),
                        'user_id'   => $row->user_id 
        );
        return response()->json($data);
    }

    public function update_receiver(Request $request)
    {
        $user_id            = $request->input('user_id');
        $current_receiver   = $request->input('receiver_id');

        $count = $this->customRepository->q_get_where($this->conn_dts,array('user2' => $current_receiver, 'received_status' => NULL, 'status' => 'torec', 'release_status' => NULL, 'to_receiver' => 'yes'),'history')->count();

        if ($count == 0) {

            $update = $this->customRepository->update_item($this->conn,'users', array('user_id' => $current_receiver), array('is_receiver' => 'no'));

            if ($update) {
                $update1 = $this->customRepository->update_item($this->conn,'users', array('user_id' => $user_id), array('is_receiver' => 'yes'));
                if ($update) {
                    $data = array('message' => 'Updated Successfully', 'response' => true);
                } else {
                    $data = array('message' => 'Something Wrong/No Changes Apply', 'response' => false);
                }

            } else {
                $data = array('message' => 'Something Wrong/No Changes Apply', 'response' => false);
            }

        } else {
            $data = array('message' => 'Current Receiver has '.$count.' pending document\'s. Please clear all to proceed in changing final receiver ', 'response' => false);
        }



        return response()->json($data);

    }

    public function get_current_oic(){
        $row = $this->customRepository->q_get_where($this->conn, array('is_oic' => 'yes'),'users')->first();
        $data = array(
                        'full_name' => $this->userService->user_full_name($row),
                        'user_id'   => $row->user_id 
        );
        return response()->json($data);
    }

    public function update_oic(Request $request)
    {
        $user_id = $request->input('user_id');
        $current_oic = $request->input('oic_id');



        $update = $this->customRepository->update_item($this->conn,'users', array('user_id' => $current_oic), array('is_oic' => 'no'));

        if ($update) {
            $this->customRepository->update_item($this->conn,'users', array('user_id' => $user_id), array('is_oic' => 'yes', 'user_type' => 'admin'));
            if ($update) {
                $data = array('message' => 'Updated Successfully', 'response' => true);
            } else {
                $data = array('message' => 'Something Wrong/No Changes Apply', 'response' => false);
            }

        } else {
            $data = array('message' => 'Something Wrong/No Changes Apply', 'response' => false);
        }

        return response()->json($data);

    }

    



}
