<?php

namespace App\Http\Controllers\systems\watchlisted\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Services\watchlisted\user\DashboardService;
use Carbon\Carbon;
class DashboardController extends Controller
{
   
    protected $conn;
    protected $customRepository;
    protected $dashboardService;
    public function __construct(CustomRepository $customRepository, DashboardService $dashboardService){
        $this->conn                 = config('custom_config.database.dts');
        $this->customRepository     = $customRepository;
        $this->dashboardService     = $dashboardService;
     
    }
    public function index(){
        $data['title']                      = 'User Dashboard';
        $data['count_approved']             = $this->customRepository->q_get_where($this->conn,array('status' => 'active','added_by'=>session('user_id')),'persons')->count();
        $data['count_pending']              = $this->customRepository->q_get_where($this->conn,array('status' => 'not-approved','added_by'=>session('user_id')),'persons')->count();
        $data['removed']                    = $this->customRepository->q_get_where($this->conn,array('status' => 'inactive','added_by'=>session('user_id')),'persons')->count();
        $data['barangay']                   = $this->dashboardService->per_barangay();
        return view('systems.watchlisted.user.pages.dashboard.dashboard')->with($data);
    }
}
