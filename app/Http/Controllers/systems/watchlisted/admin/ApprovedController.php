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
class ApprovedController extends Controller
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

        $data['title'] = 'Approved';
        return view('systems.watchlisted.admin.pages.approved.approved')->with($data);
    }


    public function get_approved_watchlisted()
    {
        $items = $this->customRepository->q_get_where_order($this->conn, 'persons',array('status' => 'active'), 'first_name', 'asc')->get();
        $i = 1;
        $data = [];
        foreach ($items as $row) {
            $data[] = array(
                'name'          => $this->userService->user_full_name($row),
                'age'           => $row->age,
                'address'       => $row->address,
                'email'         => $row->email_address,
                'phone_number'  => $row->phone_number,
                'person_id'     => $row->person_id,
                'number'        => $i++
            );

        }
        return response()->json($data);

    }

    public function change_status(Request $request)
    {
        $request = $request->input('id');
        $id = $request['id'];
        $status = $request['status'];
        $message = $status == 'active' ? 'Set Successfully' : 'Removed Successfully';
        $action =  $status == 'active' ? 'Set As Active | ' : 'Removed from Watchlisted | ';
        if (is_array($id)) {
            foreach ($id as $row) {

                $update     =   $this->customRepository->update_item($this->conn,'persons', array('person_id' => $row), array('status' => $status));
                $user_row   =   $this->customRepository->q_get_where($this->conn,array('person_id' => $row),'persons')->first();
                $this->actionLogService->wl_add_action($action = $action . $this->userService->user_full_name($user_row), 'user', $user_row->person_id);
            }
            $data = array('message' => $message, 'response' => true);
        } else {
            $update = $this->customRepository->update_item($this->conn,'persons', array('person_id' => $id), array('status' => $status));
            if ($update) {
                $data = array('message' => $message, 'response' => true);
            } else {
                $data = array('message' => 'Something Wrong/Data is not updated', 'response' => false);
            }
        }

        return response()->json($data);

    }

}
