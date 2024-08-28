<?php

namespace App\Http\Controllers\systems\watchlisted\both;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Repositories\watchlisted\PersonQuery;
use App\Services\watchlisted\user\DashboardService;
use App\Services\user\ActionLogService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class SearchController extends Controller
{
   
    protected $conn;
    protected $customRepository;
    protected $dashboardService;
    protected $actionLogService;
    protected $personQuery;
    public function __construct(CustomRepository $customRepository, DashboardService $dashboardService, ActionLogService $actionLogService, PersonQuery $personQuery){
        $this->conn                 = config('custom_config.database.dts');
        $this->customRepository     = $customRepository;
        $this->dashboardService     = $dashboardService;
        $this->actionLogService     = $actionLogService;
        $this->personQuery          = $personQuery;
     
    }

    public function search_query(Request $request){
        $search = $request->input('first_name') . ' ' . $request->input('last_name');
        $users =  $this->personQuery->search($search);
        return response()->json($users);
    }
}
