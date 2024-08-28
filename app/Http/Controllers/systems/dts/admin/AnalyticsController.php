<?php

namespace App\Http\Controllers\systems\dts\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Services\dts\admin\DashboardService;
use Carbon\Carbon;

class AnalyticsController extends Controller
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
        $data['title']      = 'Admin Analytics';
        return view('systems.dts.admin.pages.analytics.analytics')->with($data);
    }

    
    public function get_document_types_analytics(Request $request){
        
        $year = $request->input('year');
        $data = $this->dashboardService->count_documents_by_types($year);
        return response()->json($data);
        
    }

    public function get_per_month_analytics(Request $request){
        
        $year = $request->input('year');
        $data = $this->dashboardService->count_documents_per_month($year);
        return response()->json($data);
        
    }




}
