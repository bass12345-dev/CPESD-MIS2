<?php

namespace App\Http\Controllers\systems\watchlisted\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Repositories\watchlisted\PersonQuery;
use App\Services\user\ActionLogService;
use App\Services\user\UserService;
use App\Services\watchlisted\user\DashboardService;
use Carbon\Carbon;
class RemoveController extends Controller
{

    protected $conn;
    protected $customRepository;
    protected $dashboardService;
    protected $actionLogService;
    protected $userService;
    protected $personQuery;
    public function __construct(CustomRepository $customRepository, DashboardService $dashboardService, PersonQuery $personQuery, UserService $userService, ActionLogService $actionLogService)
    {
        $this->conn = config('custom_config.database.dts');
        $this->customRepository = $customRepository;
        $this->dashboardService = $dashboardService;
        $this->actionLogService = $actionLogService;
        $this->userService = $userService;
        $this->personQuery = $personQuery;

    }
    public function index()
    {

        $data['title'] = 'Removed';
        return view('systems.watchlisted.admin.pages.removed.removed')->with($data);
    }


    public function remove_from_watchlisted(){

        $items = $this->customRepository->q_get_where_order($this->conn,'persons',array('status' => 'inactive'),'first_name','asc')->get();
        $i = 1;
        $data = [];
        foreach ($items as $row) {
            $data[] = array(
                        'name'              => $this->userService->user_full_name($row),
                        'age'               => $row->age,
                        'address'           => $row->address,
                        'email'             => $row->email_address,
                        'phone_number'      => $row->phone_number,
                        'person_id'         => $row->person_id,
                        'number'            => $i++
            );
           
        }
        return response()->json($data);

    }


}
