<?php

namespace App\Http\Controllers\systems\watchlisted\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Repositories\watchlisted\PersonQuery;
use App\Services\user\UserService;
use App\Services\watchlisted\user\DashboardService;
use Carbon\Carbon;
class ActivityLogsController extends Controller
{
   
    protected $conn;
    protected $customRepository;
    protected $dashboardService;
    protected $userService;
    protected $personQuery;
    public function __construct(CustomRepository $customRepository, DashboardService $dashboardService, PersonQuery $personQuery, UserService $userService){
        $this->conn                 = config('custom_config.database.dts');
        $this->customRepository     = $customRepository;
        $this->dashboardService     = $dashboardService;
        $this->userService          = $userService;
        $this->personQuery          = $personQuery;
     
    }
    public function index(){
        $data['title']                      = 'Activity Logs';
        return view('systems.watchlisted.admin.pages.activity_logs.activity_logs')->with($data);
    }

    public function get_activity_logs(){


        $items    = $this->personQuery->QueryActivityLogs();
        $data = [];
        $i = 1;

        foreach ($items as $row) {
            $data[] = array(
                'number' => $i++,
                'name'      => $this->userService->user_full_name($row),
                'person_id' => $row->person_id,
                'action'    => $row->action,
                'user_type' => $row->user_type,
                'created'   => date('M d Y h:i A', strtotime($row->action_datetime))
            );
            
            # code...
        }
        return response()->json($data);
    
    }
}
