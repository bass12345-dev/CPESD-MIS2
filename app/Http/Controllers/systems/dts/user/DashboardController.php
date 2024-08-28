<?php

namespace App\Http\Controllers\systems\dts\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Services\dts\user\DashboardService;
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
        $data['title']              = 'User Dashboard';
        $data['count']              = $this->dashboardService->user_dashboard_display();
        $data['today']              = Carbon::now()->format('M d Y');
        $data['forwarded_to_users'] = $this->dashboardService->get_forwarded_documents();
        return view('systems.dts.user.pages.dashboard.dashboard')->with($data);
    }
}
