<?php

namespace App\Http\Controllers\systems\pmas\admin;
use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use App\Repositories\pmas\user\UserPmasQuery;
use App\Services\CustomService;
use App\Services\pmas\admin\ActionLogService;
use App\Services\user\UserService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ActivityLogsController extends Controller
{

    protected $conn;
    protected $customRepository;
    protected $customService;
    protected $userService;
    protected $actionLogsService;
    protected $userPmasQuery;

    public function __construct(CustomRepository $customRepository, CustomService $customService, UserService $userService,UserPmasQuery $userPmasQuery, ActionLogService $actionLogService)
    {

        $this->customRepository = $customRepository;
        $this->userPmasQuery    = $userPmasQuery;
        $this->customService = $customService;
        $this->userService = $userService;
        $this->actionLogsService = $actionLogService;
        $this->conn = config('custom_config.database.pmas');

    }
    public function index()
    {
        $data['current']            = Carbon::now()->year.'-'.Carbon::now()->month;
        $data['title'] = 'Activity Logs';
        return view('systems.pmas.admin.pages.activity_logs.activity_logs')->with($data);
    }


    public function get_logged_in_history(){

        // $month = '';
        // $year = '';
        // if(isset($_GET['date'])){
        //     $month =   date('m', strtotime($_GET['date']));
        //     $year =   date('Y', strtotime($_GET['date']));
        // }
        // $user = $this->actionLogsService->AllActionLogs($month,$year);
        // return response()->json($user);
        return 'heelo';
    }



}
