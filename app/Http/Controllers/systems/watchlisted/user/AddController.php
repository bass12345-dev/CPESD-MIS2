<?php

namespace App\Http\Controllers\systems\watchlisted\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Services\watchlisted\user\DashboardService;
use App\Services\user\ActionLogService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class AddController extends Controller
{
   
    protected $conn;
    protected $customRepository;
    protected $dashboardService;
    protected $actionLogService;
    public function __construct(CustomRepository $customRepository, DashboardService $dashboardService, ActionLogService $actionLogService){
        $this->conn                 = config('custom_config.database.dts');
        $this->customRepository     = $customRepository;
        $this->dashboardService     = $dashboardService;
        $this->actionLogService     = $actionLogService;
     
    }
    public function index(){
        $data['title']                      = 'Add Watchlisted';
        $data['barangay']   = config('custom_config.barangay');
        return view('systems.watchlisted.user.pages.add.add')->with($data);
    }


    public function insert_person(Request $request){

        $items = array(

            'first_name'                => $request->input('firstName'),
            'middle_name'               => $request->input('middleName'),
            'last_name'                 => $request->input('lastName'),
            'extension'                 => $request->input('extension'),
            'phone_number'              => $request->input('phoneNumber'),
            'address'                   => $request->input('address'),
            'email_address'             => $request->input('emailAddress'),
            'created_at'                => Carbon::now()->format('Y-m-d H:i:s') ,
            'status'                    => session('user_type') == 'user' ? 'not-approved' : 'active',
            'age'                       => $request->input('age'),
            'gender'                    => $request->input('gender'),
            'added_by'                  => session('user_id')
        );
        $add = DB::connection($this->conn)->table('persons')->insertGetId($items);
        if ($add) {
            
            $this->actionLogService->wl_add_action('Added New Watchlisted | ' . $items['first_name'].' '.$items['middle_name'].' '.$items['last_name'],'user', $add);
                
            $data = array('id' => $add, 'message' => 'Added Successfully', 'response' => true);
        } else {
            $data = array('message' => 'Something Wrong', 'response' => false);
        }
        return response()->json($data);

    }
}
