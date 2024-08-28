<?php

namespace App\Http\Controllers\systems\rfa\user;

use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use App\Repositories\rfa\user\RFAQuery;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
   
    protected $conn;
    protected $customRepository;
    protected $rFAQuery;

    public function __construct(CustomRepository $customRepository, RFAQuery $rFAQuery){
       
        $this->customRepository = $customRepository;
        $this->conn             = config('custom_config.database.pmas');
        $this->rFAQuery         = $rFAQuery;
    }
    public function index(){
        $data['title']                      = 'User Dashboard';
        $data['count_completed_rfa_transactions']        = $this->customRepository->q_get_where($this->conn,array('rfa_status' => 'completed','reffered_to' => session('user_id')), 'rfa_transactions')->count();
        $data['count_pending_rfa_transactions']         = $this->customRepository->q_get_where($this->conn,array('rfa_status' => 'pending','reffered_to' => session('user_id')), 'rfa_transactions')->count();
        return view('systems.rfa.user.pages.dashboard.dashboard')->with($data);
    }


    public function get_user_chart_rfa_transaction_data(Request $request){

        $year                               = $request->input('year');
        $months                             = array();
        $completed_transactions             = array();
        $pending_transactions               = array();

    
        for ($m = 1; $m <= 12; $m++) {
    
            $completed_transaction          = $this->rFAQuery->QueryUserTransactionPerMonthYear($m,$year,'completed');
            array_push($completed_transactions, $completed_transaction);
    
    
            $pending_transaction            = $this->rFAQuery->QueryUserTransactionPerMonthYear($m,$year,'pending');
            array_push($pending_transactions, $pending_transaction);
           
            $month                          =  date('M', mktime(0, 0, 0, $m, 1));
            array_push($months, $month);
        }
        $data['label']                      = $months;
        $data['data_pending']               = $pending_transactions;
        $data['data_completed']             = $completed_transactions;
        echo json_encode($data);
    

    }


  
}
