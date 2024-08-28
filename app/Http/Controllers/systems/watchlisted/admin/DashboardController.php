<?php

namespace App\Http\Controllers\systems\watchlisted\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Repositories\watchlisted\PersonQuery;
use App\Services\watchlisted\user\DashboardService;
use Carbon\Carbon;
class DashboardController extends Controller
{
   
    protected $conn;
    protected $customRepository;
    protected $dashboardService;
    protected $personQuery;
    public function __construct(CustomRepository $customRepository, DashboardService $dashboardService, PersonQuery $personQuery){
        $this->conn                 = config('custom_config.database.dts');
        $this->customRepository     = $customRepository;
        $this->dashboardService     = $dashboardService;
        $this->personQuery          = $personQuery;
     
    }
    public function index(){
        $date_now                           = Carbon::now()->format('Y-m-d');
        $data['title']                      = 'Admin Dashboard';
        $data['today']                      = Carbon::now()->format('M d Y');
        $data['gender_title']           = 'Count Approved By Gender';
        $data['watchlisted']                = $this->personQuery->QueryPersonDashboard();
        $data['programs']                   = $this->customRepository->q_get($this->conn,'programs')->count();
        $data['added_today']                        = $this->personQuery->added_today($date_now);
        $data['approved_today']                     = $this->personQuery->approved_today($date_now);
        $data['latest_approved']                    = $this->personQuery->latest_approved($limit=10);
        return view('systems.watchlisted.admin.pages.dashboard.dashboard')->with($data);
    }

    public function data_per_barangay(){


        $active     = array();
        $to_approved = array();
        $removed = array();
        $barangay   = config('custom_config.barangay');

        foreach ($barangay as $row) {

            $count = $this->customRepository->q_get_where($this->conn,array('status' => 'active', 'address' => $row),'persons')->count();
            array_push($active, $count);

            $count1 = $this->customRepository->q_get_where($this->conn,array('status' => 'not-approved', 'address' => $row),'persons')->count();
            array_push($to_approved, $count1);

            $count3 = $this->customRepository->q_get_where($this->conn,array('status' => 'inactive', 'address' => $row),'persons')->count();
            array_push($removed, $count3);

        }


        $data['label'] = $barangay;
        $data['active'] = $active;
        $data['to_approved'] = $to_approved;
        $data['removed'] = $removed;

        return response()->json($data);
    }


    public function count_gender_active_chart(Request $request){

        $year                               =   $request->input('year');
        $months                             = array();
        $male                               = array();
        $female                             = array();

        for ($m = 1; $m <= 12; $m++) {

            $total_male              = $this->personQuery->count_gender_by_month($m,$year,'male');
            array_push($male, $total_male);


            $total_female            = $this->personQuery->count_gender_by_month($m,$year,'female');
            array_push($female, $total_female);
           
            $month                          =  date('M', mktime(0, 0, 0, $m, 1));
            array_push($months, $month);
        }

        $data['label']                      = $months;
        $data['male']                       = $male;
        $data['female']                     = $female;
        return response()->json($data);

       
    }
}
