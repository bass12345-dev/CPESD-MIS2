<?php

namespace App\Http\Controllers\systems\pmas\admin;
use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use App\Repositories\pmas\user\UserPmasQuery;
use App\Services\CustomService;
use App\Services\pmas\admin\TransactionService;
use App\Services\user\UserService;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    protected $conn;
    protected $customRepository;
    protected $customService;
    protected $userService;
    protected $transactionService;
    protected $userPmasQuery;

    public function __construct(CustomRepository $customRepository, CustomService $customService, UserService $userService, UserPmasQuery $userPmasQuery, TransactionService $transactionService)
    {

        $this->customRepository = $customRepository;
        $this->userPmasQuery = $userPmasQuery;
        $this->customService = $customService;
        $this->userService = $userService;
        $this->transactionService = $transactionService;
        $this->conn = config('custom_config.database.pmas');

    }
    public function index()
    {
        $data['title'] = 'Reports';
        $data['activities'] = $this->customRepository->q_get_order($this->conn, 'type_of_activities', 'type_of_activity_name', 'asc')->get();
        $data['cso'] = $this->customRepository->q_get_order($this->conn, 'cso', 'cso_name', 'asc')->get();
        $data['rgpm_text'] = 'regular monthly project monitoring';
        return view('systems.pmas.admin.pages.report.report')->with($data);
    }

    public function generate_pmas_report(Request $request)
    {
        $date_filter = $request->input('date_filter');
        $type_of_activity = $request->input('filter_type_of_activity');
        $cso_id = $request->input('cso');


        $start = explode(" - ", $date_filter)[0];
        $end = explode(" - ", $date_filter)[1];

        $data = '';
        $filter_data =   $filter_data = array(

            'start_date' => date('Y-m-d', strtotime($start)),
            'end_date' => date('Y-m-d', strtotime($end)),
           
        );

        if ($type_of_activity != null && $cso_id == 0) {
            $filter_data['type_of_activity'] = $type_of_activity;
            $data = $this->transactionService->first_report($filter_data);

        }else if ($type_of_activity != null && $cso_id != null) {
            $filter_data['type_of_activity'] = $type_of_activity;
            $filter_data['cso_Id']           = $cso_id;
            $data = $this->transactionService->second_report($filter_data);
        }else {
            $data = $this->transactionService->third_report($filter_data);
        }

        return response()->json($data);
    }

    public function get_project_transaction_data(Request $request){

        $where = array('project_transact_id'=>$request->input('id'));
        $item = $this->customRepository->q_get_where($this->conn,$where,'project_monitoring')->first();

        $data = array(

                    'project_title'             => '<b>'.$item->project_title.'</b>',
                    'delinquent'                => $item->nom_borrowers_delinquent,
                    'overdue'                   => $item->nom_borrowers_overdue,
                    'total_production'          => $item->total_production,
                    'total_collection_sales'    => $item->total_collection_sales,
                    'total_released_purchases'  => $item->total_released_purchases,
                    'total_delinquent_account'  => $item->total_delinquent_account,
                    'total_over_due_account'    => $item->total_over_due_account,
                    'cash_in_bank'              => $item->cash_in_bank,
                    'cash_on_hand'              => $item->cash_on_hand,
                    'inventories'               => $item->inventories,
                    'total_volume_of_business'  => number_format(array_sum(array(

                                                    $item->total_collection_sales,
                                                    $item->total_released_purchases,
                                                    
                                                        )), 2, '.', ','),
                    'total_cash_position'       => number_format(array_sum(array(

                                                    $item->cash_in_bank,
                                                    $item->cash_on_hand,
                                                    $item->inventories
                                                    
                                                        )), 2, '.', ','),
                    'total'                     => number_format(array_sum(array(

                                                    $item->nom_borrowers_delinquent,
                                                    $item->nom_borrowers_overdue,
                                                    $item->total_production,
                                                    $item->total_collection_sales,
                                                    $item->total_released_purchases,
                                                    $item->total_delinquent_account,
                                                    $item->total_over_due_account,
                                                    $item->cash_in_bank,
                                                    $item->cash_on_hand,
                                                    $item->inventories

                                                        )), 2, '.', ',')
        );
        return response()->json($data);

    }




}
