<?php

namespace App\Http\Controllers\systems\dts\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Repositories\dts\AdminDtsQuery;
use App\Services\dts\admin\ActionLogsService;
use App\Services\dts\admin\DashboardService;
use Carbon\Carbon;

class ActionLogsController extends Controller
{
    protected $conn;
    protected $customRepository;
    protected $actionLogsService;
    protected $adminDtsQuery;
    public function __construct(CustomRepository $customRepository,AdminDtsQuery $adminDtsQuery, ActionLogsService $actionLogsService ){
        $this->conn                 = config('custom_config.database.dts');
        $this->customRepository     = $customRepository;
        $this->adminDtsQuery        = $adminDtsQuery;
        $this->actionLogsService   = $actionLogsService;
     
    }
    public function index(){
        $data['title']              = 'Action Logs';
        $data['current']            = Carbon::now()->year.'-'.Carbon::now()->month;
        
        return view('systems.dts.admin.pages.action_logs.action_logs')->with($data);
    }

    
    public function get_action_logs(){
        $month = '';
        $year = '';
        if(isset($_GET['date'])){
            $month =   date('m', strtotime($_GET['date']));
            $year =   date('Y', strtotime($_GET['date']));
        }
        $user = $this->actionLogsService->AllActionLogs($month,$year);
        return response()->json($user);
    }


}
