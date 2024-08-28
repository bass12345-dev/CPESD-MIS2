<?php

namespace App\Http\Controllers\systems\rfa\user;

use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use App\Repositories\rfa\user\RFAQuery;
use App\Services\CustomService;
use App\Services\user\ActionLogService;
use App\Services\user\UserService;
use Illuminate\Http\Request;

class ReferredController extends Controller
{
   
    protected $conn;
    protected $conn_user;
    protected $customRepository;
    protected $customService;
    protected $actionLogService;
    protected $userService;
    protected $rFAQuery;

    public function __construct(CustomRepository $customRepository, RFAQuery $rFAQuery, CustomService $customService, UserService $userService, ActionLogService $actionLogService){
       
        $this->customRepository = $customRepository;
        $this->customService    = $customService;
        $this->userService      = $userService;
        $this->actionLogService = $actionLogService;
        $this->conn             = config('custom_config.database.pmas');
        $this->conn_user = config('custom_config.database.users');
        $this->rFAQuery         = $rFAQuery;
    }
    public function index(){
        $data['title']                      = 'Referred Transactions';
        return view('systems.rfa.user.pages.referred.referred')->with($data);
    }


    public function get_user_referred_rfa(){

        $data = [];
        $items = $this->rFAQuery->QueryUserReferredRFA(); 
    
        foreach ($items as $row) {
    
            $client = $this->customRepository->q_get_where($this->conn,array('rfa_client_id' => $row->client_id),'rfa_clients')->first();
            $status1 = '';
            $action1 = '';
    
            if ($row->action_to_be_taken == NULL) {
    
                $status1 = '<a href="javascript:;" class="btn btn-danger btn-rounded p-1 pl-2 pr-2">No Action</a><br>
                            <a href="javascript:;" id="view_action_taken_admin" data-id="'.$row->rfa_id.'" >View Action Taken</a>';
                $action1 = '<ul class="d-flex justify-content-center">
                                <li class="mr-3 "><a href="javascript:;" class="text-success action-icon" data-id="'.$row->rfa_id.'" data-toggle="modal" data-target="#accomplished_modal" data-name="'.$this->customService->ref_number($row).'" id="accomplished" ><i class="fa fa-check"></i></a></li>
                            </ul>';
            }else if ($row->action_to_be_taken != NULL && $row->accomplished_status != 0) {
                $status1 = '<a href="javascript:;" class="btn btn-success btn-rounded p-1 pl-2 pr-2">For Approval</a>';
            }
    
    
            $data[] = array(
    
                            'rfa_id'                => $row->rfa_id ,
                            'name'                  => $this->userService->user_full_name($client),
                            'type_of_request_name'  => $row->type_of_request_name,
                            'type_of_transaction'   => $row->type_of_transaction,
                            'address'               => 'Purok '.$client->purok == 0 ? $client->barangay : 'Purok '.$client->purok.' '.$client->barangay,
                            'ref_number'            => '<a href="'.url('').'/user/rfa/view-rfa/'.$row->rfa_id.'">'.$this->customService->ref_number($row).'</a>',
                            'status1'               => $status1,
                            'action1'               => $action1
                            
    
                           
                    );
    
        }
    
        return response()->json($data);
    }



    public function view_action_taken(Request $request){
        $data = [];
        $where = array('rfa_id'=>$request->input('id'));
        $data['action_taken'] = $this->customRepository->q_get_where($this->conn,$where,'rfa_transactions')->first()->action_taken;
        $data['rfa_id'] = $where['rfa_id']; 
        return response()->json($data);
    }

    public function accomplish_rfa(Request $request){
        $where = array('rfa_id' => $request->input('rfa_id'));
        $data = array(
            'accomplished_status'            => 1,
            'action_to_be_taken'             => $request->input('action_to_be_taken'),
            'action_to_be_taken_date_time'   => date('Y-m-d H:i:s', time()),
        );

        $update             = $this->customRepository->update_item($this->conn,'rfa_transactions',$where,$data);
        if ($update) {
    
            $rfa_item       = $this->customRepository->q_get_where($this->conn,array('rfa_id' =>  $where['rfa_id']),'rfa_transactions')->first();
            $this->actionLogService->add_pmas_rfa_action('rfa',$where['rfa_id'],'Accomplished RFA No. '. $this->customService->ref_number($rfa_item));
            $resp = array('message' => 'RFA No. '.$this->customService->ref_number($rfa_item).' Accomplished Successfully', 'response' => true);
        } else {
            $resp = array('message' => 'Error', 'response' => false);
        }
        return response()->json($resp);

    }


  
}
