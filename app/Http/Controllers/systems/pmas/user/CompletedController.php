<?php

namespace App\Http\Controllers\systems\pmas\user;
use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use App\Repositories\pmas\user\UserPmasQuery;
use App\Services\CustomService;
use App\Services\user\UserService;
use Illuminate\Http\Request;

class CompletedController extends Controller
{

    protected $conn;
    protected $customRepository;
    protected $customService;
    protected $userService;

    protected $userPmasQuery;

    public function __construct(CustomRepository $customRepository, CustomService $customService, UserService $userService, UserPmasQuery $userPmasQuery)
    {

        $this->customRepository = $customRepository;
        $this->userPmasQuery = $userPmasQuery;
        $this->customService = $customService;
        $this->userService = $userService;
        $this->conn = config('custom_config.database.pmas');

    }
    public function index()
    {
        $data['title'] = 'Completed';
        return view('systems.pmas.user.pages.completed.completed')->with($data);
    }


    public function get_user_completed_transactions()
    {
        $items = $this->userPmasQuery->QueryUserCompletedTransactions();
        $data = [];

        foreach ($items as $row) {

            $data[] = array(
                'transaction_id'            => $row->transaction_id,
                'pmas_no'                   => '<b>' . date('Y', strtotime($row->date_and_time_filed)) . ' - ' . date('m', strtotime($row->date_and_time_filed)) . ' - ' . $row->number . '</b>',
                'date_and_time_filed'       => date('F d Y', strtotime($row->date_and_time_filed)) . ' ' . date('h:i a', strtotime($row->date_and_time_filed)),
                'type_of_activity_name'     => strtolower($row->type_of_activity_name) == strtolower('Regular Monthly Project Monitoring') ? '<a href="javascript:;"    data-id="' . $row->transaction_id . '"  style="color: #000; "  >' . $row->type_of_activity_name . '</a>' : $row->type_of_activity_name,
                'cso_name'                  => strtolower($row->type_of_activity_name) == strtolower('Regular Monthly Project Monitoring') ? '<a href="javascript:;" data-title="' . $row->cso_name . '" id="view_project_monitoring"    data-id="' . $row->transaction_id . '"  style="color: #000; font-weight: bold;"  >' . $row->cso_name . '</a>' : $row->cso_name,
                'name'                      => $this->userService->user_full_name($row),

            );
        }

        return response()->json($data);

    }







}
