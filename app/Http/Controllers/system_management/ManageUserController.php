<?php

namespace App\Http\Controllers\system_management;

use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use App\Services\CustomService;
use App\Services\user\UserService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ManageUserController extends Controller
{

    protected $conn;
    protected $customRepository;
    protected $customService;
    protected $userService;
    protected $user_table;
    protected $user_system_authorized_table;
    public function __construct(CustomRepository $customRepository, UserService $uSerService, CustomService $customService)
    {
        $this->customRepository = $customRepository;
        $this->userService = $uSerService;
        $this->customService = $customService;
        $this->conn = config('custom_config.database.users');
        $this->user_table = 'users';
        $this->user_system_authorized_table = 'user_system_authorized';
    }
    public function index()
    {
        $data['title'] = 'Manage Users';
        return view('system_management.contents.manage_users.manage_users')->with($data);
    }

    public function get_all_users()
    {
        $items = $this->customRepository->q_get_where($this->conn, array('user_type' => 'user'), $this->user_table)->get();
        $data = [];
        $i = 1;
        foreach ($items as $value => $key) {
            $data[] = array(
                'i' => $i++,
                'user_id' => $key->user_id,
                'full_name' => $this->userService->user_full_name($key),
                'username' => $key->username,
                'address' => $key->address,
                'email_address' => $key->email_address,
                'phone_number' => $key->contact_number,
                'status' => $key->user_status
            );
        }
        return response()->json($data);
    }

    public function change_user_status(Request $request)
    {
        $id = $request->input('id');
        $items = array(
            'user_status' => $request->input('status')
        );

        $update = $this->customRepository->update_item($this->conn, $this->user_table, array('user_id' => $id), $items);
        if ($update) {

            $data = array('message' => 'Status Updated Successfully', 'response' => true);
        } else {

            $data = array('message' => 'Error', 'response' => false);
        }

        return response()->json($data);
    }

    public function delete_user(Request $request)
    {
        $id = $request->input('id');
        $delete = $this->customRepository->delete_item($this->conn,$this->user_table, array('user_id' => $id));

        if ($delete) {

            $data = array('message' => 'Deleted Succesfully', 'response' => true);
        } else {
            $data = array('message' => 'Error', 'response' => false);
        }

        return response()->json($data);
    }

    public function view_profile($id)
    {
        $row = $this->customRepository->q_get_where($this->conn, array('user_id' => $id), $this->user_table);

        if ($row->count() > 0) {
            $user_row = $row->first();
            $data['title'] = $this->userService->user_full_name($user_row);
            $data['user'] = $user_row;
            $data['systems'] = $this->user_system_authorized($id);
            return view('system_management.contents.manage_users.view_profile.view_profile')->with($data);
        } else {
            echo 404;
        }
    }

    private function user_system_authorized($id)
    {

        $systems = config('custom_config._systems');
        $data = [];
        foreach ($systems as $key => $value) {
            $user_row = $this->customRepository->q_get_where($this->conn, array('system_authorized' => $key, 'user_id' => $id), $this->user_system_authorized_table)->count();
            $data[] = array(
                'system_id'     => $key,
                'system_name'   => $value,
                'is_checked'    => $user_row == 1 ? 'checked' : ''
            );
        }

        return $data;
    }

    public function authorize_system(Request $request)
    {

        $ids = $request->input('id');
        $user_id = $request->input('user_id');
        $this->customRepository->delete_item($this->conn,  $this->user_system_authorized_table, array('user_id' => $user_id));
        if (is_array($ids)) {
            foreach ($ids as $row) {
                $item = array(
                    'user_id' => $user_id,
                    'system_authorized' => $row,
                    'updated_on' => Carbon::now()->format('Y-m-d H:i:s'),
                );
                $add = $this->customRepository->insert_item($this->conn, $this->user_system_authorized_table, $item);
            }
            $data = array('message' => 'Added Succesfully', 'response' => true);
        } else {
            $this->customRepository->delete_item($this->conn,  $this->user_system_authorized_table, array('user_id' => $user_id));
            $data = array('message' => 'Removed Succesfully', 'response' => true);
        }
        return response()->json($data);
    }


    public function check_authorized()
    {

        $count = $this->customRepository->q_get_where($this->conn, array('system_authorized' => $_GET['sys'], 'user_id' => session('user_id')), $this->user_system_authorized_table)->count();
        if ($count || session('user_type') == 'admin') {
            $link = $_GET['sys'] == 'cso' || $_GET['sys'] == 'dts' || $_GET['sys'] == 'lls' ? 'user' : session('user_type');
            $data = array('message' => '/' . $link . '/' . $_GET['sys'] . '/dashboard', 'response' => true);
        } else {
            $data = array('message' => 'You are not Authorized', 'response' => false);
        }
        return response()->json($data);
    }
}
