<?php

namespace App\Http\Controllers\systems\watchlisted\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Services\user\ActionLogService;
use App\Services\user\UserService;
use App\Services\watchlisted\user\DashboardService;
use Carbon\Carbon;
class PendingController extends Controller
{

    protected $conn;
    protected $customRepository;
    protected $dashboardService;
    protected $actionLogService;
    protected $userService;
    public function __construct(CustomRepository $customRepository, DashboardService $dashboardService, ActionLogService $actionLogService, UserService $userService)
    {
        $this->conn = config('custom_config.database.dts');
        $this->customRepository = $customRepository;
        $this->dashboardService = $dashboardService;
        $this->actionLogService = $actionLogService;
        $this->userService = $userService;

    }
    public function index()
    {
        $data['title'] = 'Pending';
        return view('systems.watchlisted.user.pages.pending.pending')->with($data);
    }

    public function get_pending_watchlisted()
    {

        $items = $this->customRepository->q_get_where_order($this->conn, 'persons', array('added_by' => session('user_id'), 'status' => 'not-approved'), 'created_at', 'desc')->get();
        $i = 1;
        $data = [];
        foreach ($items as $row) {
            $data[] = array(
                'name' => $row->first_name . ' ' . $row->middle_name . ' ' . $row->last_name . ' ' . $row->extension,
                'age' => $row->age,
                'address' => $row->address,
                'email' => $row->email_address,
                'phone_number' => $row->phone_number,
                'person_id' => $row->person_id,
                'number' => $i++
            );

        }
        return response()->json($data);
    }

    //DELETE

    public function delete_person(Request $request)
    {
        $id = $request->input('id')['id'];
        if (is_array($id)) {
            foreach ($id as $row) {
                $user_row = $this->customRepository->q_get_where($this->conn, array('person_id' => $row), 'persons')->first();
                $this->actionLogService->wl_add_action('Deleted "' . $this->userService->user_full_name($user_row), session('user_type'), $user_row->person_id);
                $where = array('person_id' => $row);
                $delete = $this->customRepository->delete_item($this->conn, 'persons', $where);
                if ($delete) {

                    $this->customRepository->delete_item($this->conn, 'records', array('p_id' => $row));
                }
            }
            $data = array('message' => 'Deleted Succesfully', 'response' => true);
        } else {
            $data = array('message' => 'Error', 'response' => false);
        }

        return response()->json($data);
    }
}
