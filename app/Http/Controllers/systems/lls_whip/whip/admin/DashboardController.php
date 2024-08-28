<?php

namespace App\Http\Controllers\systems\lls_whip\whip\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Repositories\whip\ContractorQuery;
use App\Repositories\whip\MonitoringQuery;
use App\Repositories\whip\ProjectQuery;

class DashboardController extends Controller
{
    protected $conn;
    protected $customRepository;
    protected $contractorQuery;
    protected $monitoringQuery;
    protected $projectQuery;
    protected $contractors_table;
    protected $projects_table;
    protected $positions_table;
    public function __construct(CustomRepository $customRepository, ContractorQuery $contractorQuery, ProjectQuery $projectQuery , MonitoringQuery $monitoringQuery)
    {
        $this->conn                 = config('custom_config.database.lls_whip');
        $this->customRepository     = $customRepository;
        $this->contractorQuery      = $contractorQuery;
        $this->monitoringQuery      = $monitoringQuery;
        $this->projectQuery         = $projectQuery;
        $this->contractors_table    = 'contractors';
        $this->projects_table       = 'projects';
        $this->positions_table      = 'positions';
    }
    public function index()
    {

        $data['title'] = 'Admin Dashboard';
        $data['count_contractors']  = $this->customRepository->q_get($this->conn, $this->contractors_table)->count();
        $data['count_whip_positions']  = $this->customRepository->q_get_where($this->conn, array('type' => 'whip'), $this->positions_table)->count();
        $data['pending_projects']    = $this->customRepository->q_get_where($this->conn, array('project_status' => 'ongoing'), $this->projects_table)->count();
        $data['completed_projects']  = $this->customRepository->q_get_where($this->conn, array('project_status' => 'completed'), $this->projects_table)->count();
        $data['pending_monitoring']    = $this->customRepository->q_get_where($this->conn, array('monitoring_status' => 'pending'), 'project_monitoring')->count();
        $data['approved_monitoring']  = $this->customRepository->q_get_where($this->conn, array('monitoring_status' => 'approved'), 'project_monitoring')->count();

        $data['contractors_data'] = $this->contractorQuery->QueryContractorOngoingAndCompleted();
        return view('systems.lls_whip.whip.admin.pages.dashboard.dashboard')->with($data);
    }

    public function analytics()
    {
        $data['title'] = 'Admin Analytics';
        return view('systems.lls_whip.whip.admin.pages.analytics.analytics')->with($data);
    }


    //Contractor Pie Chart

    public function get_contractors_inside_outside()
    {

        $res            = $this->contractorQuery->QueryContractorInsideOutside();
        $label          = [];
        $total          = [];
        foreach ($res as $tempKey => $row) {
            array_push($label, $tempKey);
            array_push($total, $row);
        }

        $data['label']   = $label;
        $data['total']   = $total;
        $data['color']   = ['#2E236C', '#684B49'];
        return response()->json($data);
    }

    public function get_workers_inside_outside()
    {

        $res            = $this->contractorQuery->QueryWorkersInsideOutside();
        $label          = [];
        $total          = [];
        foreach ($res as $tempKey => $row) {
            array_push($label, $tempKey);
            array_push($total, $row);
        }

        $data['label']   = $label;
        $data['total']   = $total;
        $data['color']   = ['#2E236C', '#684B49'];
        return response()->json($data);
    }

    public function get_projects_per_barangay()
    {


        $ongoing = [];
        $completed = [];
        $barangay = config('custom_config.barangay');
        foreach ($barangay as $row) {
            $count_ongoing = $this->projectQuery->projects_per_barangay($row, 'ongoing');
            array_push($ongoing, $count_ongoing);
            $count_completed = $this->projectQuery->projects_per_barangay($row, 'completed');
            array_push($completed, $count_completed);
        }
        $data['label']               = $barangay;
        $data['data_ongoing']        = $ongoing;
        $data['data_completed']      = $completed;
        $data['color'] = ['rgb(41,134,204)', 'rgb(201,0,118)'];
        return response()->json($data);
    }

    public function get_monitoring_analytics()
    {

        $months           = array();
        $approved        = array();
        $pending          = array();
        $year             = $_GET['year'];

        for ($m = 1; $m <= 12; $m++) {

            $approved_doc          =  $this->monitoringQuery->get_whip_monitoring_where_and_year_and_month(array('monitoring_status' => 'approved'), $year, $m)->count();
            $pending_doc            =  $this->monitoringQuery->get_whip_monitoring_where_and_year_and_month(array('monitoring_status' => 'pending'), $year, $m)->count();
            $month                  =  date('M', mktime(0, 0, 0, $m, 1));
            array_push($months, $month);
            array_push($approved, $approved_doc);
            array_push($pending, $pending_doc);
        }
        $data['label']                      = $months;
        $data['data_pending']               = $pending;
        $data['data_approved']             = $approved;

        return response()->json($data);
    }
}
