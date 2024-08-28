<?php

namespace App\Http\Controllers\systems\watchlisted\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Repositories\watchlisted\PersonQuery;
use App\Services\user\ActionLogService;
use App\Services\user\UserService;
use App\Services\watchlisted\user\DashboardService;
use Carbon\Carbon;
class ToApproveController extends Controller
{
   
    protected $conn;
    protected $customRepository;
    protected $dashboardService;
    protected $actionLogService;
    protected $userService;
    protected $personQuery;
    public function __construct(CustomRepository $customRepository, DashboardService $dashboardService, PersonQuery $personQuery, UserService $userService, ActionLogService $actionLogService){
        $this->conn                 = config('custom_config.database.dts');
        $this->customRepository     = $customRepository;
        $this->dashboardService     = $dashboardService;
        $this->actionLogService     = $actionLogService;
        $this->userService          = $userService;
        $this->personQuery          = $personQuery;
     
    }
    public function index(){
      
        $data['title']                      = 'Admin Dashboard';
        return view('systems.watchlisted.admin.pages.to_approved.to_approved')->with($data);
    }

    public function to_approved_watchlisted(){

        $items       = $this->personQuery->QueryToApprove();
        $i = 1;
        $data = [];
        foreach ($items as $row) {
            $data[] = array(
                        'name'              => $this->userService->user_full_name($row),
                        'age'               => $row->age,
                        'address'           => $row->address,
                        'email'             => $row->email_address,
                        'phone_number'      => $row->phone_number,
                        'person_id'         => $row->person_id,
                        'encoded_by'        => $this->userService->user_full_name($row),
                        'number'            => $i++
            );
           
        }
        return response()->json($data);
        

    }

    public function approved_watchlisted(Request $request){
        $id = $request->input('id')['id'];
        if (is_array($id)) {
            foreach ($id as $row) {
                
                $update = $this->customRepository->update_item($this->conn,'persons', array('person_id' => $row), array('status'=> 'active'));
                $user_row = $this->customRepository->q_get_where($this->conn,array('person_id' => $row),'persons')->first();
               $this->actionLogService->wl_add_action('Approved New Watchlisted | ' . $this->userService->user_full_name($user_row), session('user_type'), $user_row->person_id);
            }
            $data = array('message' => 'Approved Succesfully' , 'response' => true);
        }else{
             $data = array('message' => 'Error' , 'response' => false );
        }

        return response()->json($data);

    }
}
