<?php

namespace App\Http\Controllers\systems\pmas\user;
use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use App\Repositories\pmas\user\UserPmasQuery;
use App\Services\CustomService;
use App\Services\user\UserService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    protected $conn;
    protected $customRepository;
    protected $customService;
    protected $userService;

    protected $userPmasQuery;

    public function __construct(CustomRepository $customRepository, CustomService $customService, UserService $userService,UserPmasQuery $userPmasQuery)
    {

        $this->customRepository = $customRepository;
        $this->userPmasQuery    = $userPmasQuery;
        $this->customService = $customService;
        $this->userService = $userService;
        $this->conn = config('custom_config.database.pmas');

    }
    public function index()
    {
        $data['title'] = 'User Dashboard';
        $data['count_complete_transactions'] = $this->customRepository->q_get_where($this->conn, array('transaction_status' => 'completed', 'created_by' => session('user_id')), 'transactions')->count();
        $data['count_pending_transactions'] = $this->customRepository->q_get_where($this->conn, array('transaction_status' => 'pending', 'created_by' => session('user_id')), 'transactions')->count();
        $data['count_po'] = $this->customRepository->q_get_where($this->conn, array('type_of_cso' => 'PO'), 'cso')->count();
        $data['count_coop'] = $this->customRepository->q_get_where($this->conn, array('type_of_cso' => 'Coop'), 'cso')->count();
        $data['count_nsc'] = $this->customRepository->q_get_where($this->conn, array('type_of_cso' => 'NSC'), 'cso')->count();
        return view('systems.pmas.user.pages.dashboard.dashboard')->with($data);
    }


    public function get_user_chart_transaction_data(Request $request)
    {
        $year = $request->input('year');
        $months = array();
        $completed_transactions = array();
        $pending_transactions = array();
        $where = array('created_by' => session('user_id'));
        for ($m = 1; $m <= 12; $m++) {

            $completed_transaction = $this->userPmasQuery->QueryUserTransactionPerMonthYear($m,$year,'completed');
            array_push($completed_transactions, $completed_transaction);


            $pending_transaction = $this->userPmasQuery->QueryUserTransactionPerMonthYear($m,$year,'pending');
            array_push($pending_transactions, $pending_transaction);

            $month = date('M', mktime(0, 0, 0, $m, 1));
            array_push($months, $month);
        }


        $data['label'] = $months;
        $data['data_pending'] = $pending_transactions;
        $data['data_completed'] = $completed_transactions;
       return response()->json($data);

    }





}
