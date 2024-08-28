<?php

namespace App\Http\Controllers\systems\dts\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Services\dts\admin\DashboardService;
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
        $data['title']      = 'Admin Dashboard';
        $data['count']      = $this->dashboardService->count_menu_data();
        $data['today']      = Carbon::now()->format('M d Y');
        $data['inactive']   =  $this->dashboardService->calculate_inactive_logged();
        return view('systems.dts.admin.pages.dashboard.dashboard')->with($data);
    }

    





}
