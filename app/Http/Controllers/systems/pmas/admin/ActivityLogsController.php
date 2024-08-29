<?php

namespace App\Http\Controllers\systems\pmas\admin;
use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use App\Repositories\pmas\user\UserPmasQuery;
use App\Services\CustomService;
use App\Services\user\UserService;
use Carbon\Carbon;

class ActivityLogsController extends Controller
{

    protected $conn;
    protected $customRepository;
    protected $customService;
    protected $userService;

    protected $userPmasQuery;

    public function __construct(CustomRepository $customRepository, CustomService $customService, UserService $userService,UserPmasQuery $userPmasQuery)
    {

        $this->customRepository = $customRepository;
        $this->userPmasQuery    = $userPmasQuery;
        $this->customService = $customService;
        $this->userService = $userService;
     
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
