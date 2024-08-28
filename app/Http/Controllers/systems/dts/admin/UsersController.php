<?php

namespace App\Http\Controllers\systems\dts\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Services\CustomService;
use App\Services\user\UserService;
use Carbon\Carbon;

class UsersController extends Controller
{
    protected $conn;
    protected $customRepository;
    protected $customService;
    protected $userService;
    public function __construct(CustomRepository $customRepository, CustomService $customService, UserService $userService){
        $this->conn                 = config('custom_config.database.users');
        $this->customRepository     = $customRepository;
        $this->customService       = $customService;
        $this->userService          = $userService;
     
    }
    public function index(){
        $data['title']      = 'Manage User';
        return view('systems.dts.admin.pages.manage_users.manage_users')->with($data);
    }

    public function get_all_users(){
        $items    = $this->customRepository->q_get_where($this->conn,array('user_type' => 'user'),'users')->get();
        $i        = 1;
        foreach ($items as $value => $key) {
            $data[] = array(
                'number'                => $i++,
                'user_id'               => $key->user_id,
                'name'                  => $this->userService->user_full_name($key),
                'username'              => $key->username,
                'address'               => $key->address,
                'email_address'         => $key->email_address,
                'contact_number'        => $key->contact_number,
                'user_status'           => $key->user_status,
                'created'               => date('M d Y h:i A', strtotime($key->user_created))
            );
        }
        return response()->json($data);
    }
    



}
