<?php

namespace App\Http\Controllers\systems\rfa\admin;
use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use App\Repositories\rfa\admin\AdminRFAQuery;
use App\Services\CustomService;
use App\Services\user\UserService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    protected $conn;
    protected $customRepository;
    protected $customService;
    protected $userService;
    protected $rFAQuery;

    public function __construct(CustomRepository $customRepository, AdminRFAQuery $rFAQuery, CustomService $customService, UserService $userService){
       
        $this->customRepository = $customRepository;
        $this->customService    = $customService;
        $this->userService      = $userService;
        $this->conn             = config('custom_config.database.pmas');
        $this->rFAQuery         = $rFAQuery;
    }
    public function index(){
        $data['title']                                  = 'Admin Dashboard';
        $data['count_completed_rfa_transactions']       = $this->customRepository->q_get_where($this->conn,array('rfa_status' => 'completed'),'rfa_transactions')->count(); 
        $data['count_pending_rfa_transactions']         = $this->customRepository->q_get_where($this->conn,array('rfa_status' => 'pending'),'rfa_transactions')->count(); 
        return view('systems.rfa.admin.pages.dashboard.dashboard')->with($data);
    }


    public function get_admin_chart_rfa_transaction_data(Request $request){

        $year                               = $request->input('year');
        $months                             = array();
        $completed_transactions             = array();
        $pending_transactions               = array();
        for ($m = 1; $m <= 12; $m++) {

            $completed_transaction          = $this->rFAQuery->QueryCountTransactionMonthYear($m,$year,'completed');
            array_push($completed_transactions, $completed_transaction);


            $pending_transaction            = $this->rFAQuery->QueryCountTransactionMonthYear($m,$year,'pending');
            array_push($pending_transactions, $pending_transaction);
           
            $month                          =  date('M', mktime(0, 0, 0, $m, 1));
            array_push($months, $month);
        }
        $data['label']                      = $months;
        $data['data_pending']               = $pending_transactions;
        $data['data_completed']             = $completed_transactions;
        return response()->json($data);
    }



    public function get_admin_pending_rfa_transaction_limit(){

        $data = [];

        $items = $this->rFAQuery->QueryPendingRFALIMIT(10);
    
        foreach ($items as $row ) {
    
                    $data[] = array(
    
                            'rfa_id'                => $row->rfa_id ,
                            'name'                  => $row->client_first_name.' '.$row->client_middle_name.' '.$row->client_last_name.' '.$row->client_extension,
                            'type_of_request_name'  => $row->type_of_request_name,
                            'type_of_transaction'   => $row->type_of_transaction,
                            'address'               => $row->client_purok == 0 ? $row->client_barangay : $row->client_purok.' '.$row->client_barangay,
                             'ref_number'           => $this->customService->ref_number($row),
                             'created_by'           => $this->userService->user_full_name($row)
                    );
        }

        return response()->json($data);
    

    }


  
}
