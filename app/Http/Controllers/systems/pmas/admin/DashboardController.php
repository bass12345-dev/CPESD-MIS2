<?php

namespace App\Http\Controllers\systems\pmas\admin;
use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use App\Repositories\pmas\admin\AdminPmasQuery;
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

    protected $adminPmasQuery;

    public function __construct(CustomRepository $customRepository, CustomService $customService, UserService $userService, AdminPmasQuery $adminPmasQuery)
    {

        $this->customRepository = $customRepository;
        $this->adminPmasQuery = $adminPmasQuery;
        $this->customService = $customService;
        $this->userService = $userService;
        $this->conn = config('custom_config.database.pmas');

    }
    public function index()
    {
        $data['title'] = 'Admin Dashboard';
        $data['count_complete_transactions'] = $this->customRepository->q_get_where($this->conn, array('transaction_status' => 'completed'), 'transactions')->count();
        $data['count_pending_transactions'] = $this->customRepository->q_get_where($this->conn, array('transaction_status' => 'pending'), 'transactions')->count();
        $data['count_po'] = $this->customRepository->q_get_where($this->conn, array('type_of_cso' => 'PO'), 'cso')->count();
        $data['count_coop'] = $this->customRepository->q_get_where($this->conn, array('type_of_cso' => 'Coop'), 'cso')->count();
        $data['count_nsc'] = $this->customRepository->q_get_where($this->conn, array('type_of_cso' => 'NSC'), 'cso')->count();
        return view('systems.pmas.admin.pages.dashboard.dashboard')->with($data);
    }


    public function get_admin_chart_transaction_data(Request $request)
    {
        $year = $request->input('year');
        $months = array();
        $completed_transactions = array();
        $pending_transactions = array();

        for ($m = 1; $m <= 12; $m++) {

            $completed_transaction = $this->adminPmasQuery->QueryAdminTransactionPerMonthYear($m, $year, 'completed');
            array_push($completed_transactions, $completed_transaction);


            $pending_transaction = $this->adminPmasQuery->QueryAdminTransactionPerMonthYear($m, $year, 'pending');
            array_push($pending_transactions, $pending_transaction);

            $month = date('M', mktime(0, 0, 0, $m, 1));
            array_push($months, $month);
        }


        $data['label'] = $months;
        $data['data_pending'] = $pending_transactions;
        $data['data_completed'] = $completed_transactions;
        return response()->json($data);
    }


    public function get_admin_chart_cso_data()
    {
        $csos = array();
        $cso_status = ['active', 'inactive'];
        foreach ($cso_status as $row) {

            $cso = $this->customRepository->q_get_where($this->conn, array('cso_status' => $row), 'cso')->count();
            array_push($csos, $cso);
        }

        $data['label'] = $cso_status;
        $data['cso'] = $csos;
        $data['color'] = ['rgb(5, 176, 133)', 'rgb(216, 88, 79)'];
        return response()->json($data);
    }





}
