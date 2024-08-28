<?php

namespace App\Http\Controllers\systems\dts\receiver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Services\dts\admin\DashboardService;
use App\Services\dts\receiver\ReceiverService;
use Carbon\Carbon;

class DashboardController extends Controller
{
    protected $conn;
    protected $customRepository;
    protected $dashboardService;
    protected $receiverService;
    public function __construct(CustomRepository $customRepository, DashboardService $dashboardService, ReceiverService $receiverService){
        $this->conn                 = config('custom_config.database.dts');
        $this->customRepository     = $customRepository;
        $this->dashboardService     = $dashboardService;
        $this->receiverService      = $receiverService;
     
    }
    public function index(){
        $data['title']      = 'Receiver\'s Dashboard';
        $data['count']      = $this->receiverService->countmydoc_dash();
        $data['today']      = Carbon::now()->format('M d Y');
        return view('systems.dts.receiver.pages.dashboard.dashboard')->with($data);
       
    }

    





}
