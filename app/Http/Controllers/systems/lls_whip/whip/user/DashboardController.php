<?php

namespace App\Http\Controllers\systems\lls_whip\whip\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Repositories\whip\ContractorQuery;

class DashboardController extends Controller
{
   
    protected $conn;
    protected $customRepository;
    protected $contractorQuery;
    protected $contractors_table;
    protected $projects_table;
    protected $positions_table;
    public function __construct(CustomRepository $customRepository, ContractorQuery $contractorQuery){
        $this->conn                 = config('custom_config.database.lls_whip');
        $this->customRepository     = $customRepository;
        $this->contractorQuery      = $contractorQuery;
        $this->contractors_table    = 'contractors';
        $this->projects_table       = 'projects';
        $this->positions_table      = 'positions';
    }
    public function index(){

        $data['title']              = 'User Dashboard';
        $data['count_contractors']  = $this->customRepository->q_get($this->conn,$this->contractors_table)->count();
        $data['count_whip_positions']  = $this->customRepository->q_get_where($this->conn,array('type' => 'whip'),$this->positions_table)->count();
        $data['pending_projects']    = $this->customRepository->q_get_where($this->conn,array('project_status' => 'ongoing'),$this->projects_table)->count();
        $data['completed_projects']  = $this->customRepository->q_get_where($this->conn,array('project_status' => 'completed'),$this->projects_table)->count();

        $data['pending_monitoring']  = $this->customRepository->q_get_where($this->conn,array('monitoring_status' => 'pending','added_by' => session('user_id')),'project_monitoring')->count();
        $data['approved_monitoring']  = $this->customRepository->q_get_where($this->conn,array('monitoring_status' => 'approved','added_by' => session('user_id')),'project_monitoring')->count();

        $data['contractors_data'] = $this->contractorQuery->QueryContractorOngoingAndCompleted();
        return view('systems.lls_whip.whip.user.pages.dashboard.dashboard')->with($data);
    }
}
