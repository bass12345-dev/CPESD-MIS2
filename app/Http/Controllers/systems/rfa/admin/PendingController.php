<?php

namespace App\Http\Controllers\systems\rfa\admin;
use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use App\Repositories\rfa\admin\AdminRFAQuery;
use App\Repositories\rfa\user\RFAQuery;
use App\Services\CustomService;
use App\Services\user\ActionLogService;
use App\Services\user\UserService;
use Illuminate\Http\Request;
use Carbon\Carbon;
class PendingController extends Controller
{

    protected $conn;
    protected $conn_user;
    protected $customRepository;
    protected $customService;
    protected $actionLogService;
    protected $userService;
    protected $rFAQuery;
    protected $userRFAQuery;

    public function __construct(CustomRepository $customRepository, AdminRFAQuery $rFAQuery, CustomService $customService, UserService $userService, ActionLogService $actionLogService, RFAQuery $userRFAQuery){
       
        $this->customRepository = $customRepository;
        $this->customService    = $customService;
        $this->userService      = $userService;
        $this->actionLogService = $actionLogService;
        $this->conn             = config('custom_config.database.pmas');
        $this->conn_user = config('custom_config.database.users');
        $this->rFAQuery         = $rFAQuery;
        $this->userRFAQuery     = $userRFAQuery;
    }
    public function index(){
        $data['title']                                  = 'Pending';
        $data['refer_to'] = $this->customRepository->q_get_where_order($this->conn_user,'users',array('user_type' => 'user'),'first_name','desc')->get(); 
        return view('systems.rfa.admin.pages.pending.pending')->with($data);
    }

    public function view_rfa($id){
       
        $row = $this->customRepository->q_get_where($this->conn, array('rfa_id' => $id), 'rfa_transactions');
        if ($row->count()) {
            $rfa_row       = $this->rFAQuery->QueryRFAData($id);
            $data['title'] = $this->customService->ref_number($rfa_row);
            $data['data']   = $rfa_row;
            return view('systems.rfa.both.view.view')->with($data);

        }else {
            echo '404';
        }

        
        
    }

    public function get_admin_pending_rfa(){

        $data = [];
        $items = $this->rFAQuery->QueryPendingRFA();

        foreach ($items as $row) {

            $action1 = '';
            $status1 = '';

            
            if ($row->reffered_to == NULL ) {
                    $status1 = '<a href="javascript:;" class="btn btn-danger btn-rounded p-1 pl-2 pr-2">needs to be refer</a>';
                    $action1 = '<div class="btn-group dropleft">
                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ti-settings" style="font-size : 15px;"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="javascript:;" data-id="'.$row->rfa_id.'" id="refer_to" data-toggle="modal" data-target="#refer_to_modal"  >Refer to</a>
                                </di>';
                }else if ($row->reffered_to != NULL && $row->accomplished_status == 0) {
     
                    $status1 = '<a href="javascript:;" class="btn btn-warning btn-rounded p-1 pl-2 pr-2">Referred</a>
                     <br>'.$row->reffered_first_name.' '.$row->reffered_middle_name.' '.$row->reffered_last_name.' '.$row->reffered_extension;
                     $action1 = '<ul class="d-flex justify-content-center">
                                <li class="mr-3 "><a href="javascript:;" class="text-secondary action-icon" data-id="'.$row->rfa_id.'"   id="view_rfa_" ><i class="fa fa-eye"></i></a></li>
                                </ul>';
                }else if ($row->reffered_to != NULL && $row->accomplished_status == 1) {
                    $status1 = '<a href="javascript:;" class="btn btn-success btn-rounded p-1 pl-2 pr-2">Accomplished</a><br>
                                <a href="javascript:;" id="view_action" data-id="'.$row->rfa_id.'" >View</a><br>'.$row->reffered_first_name.' '.$row->reffered_middle_name.' '.$row->reffered_last_name.' '.$row->reffered_extension;
                    $action1 = '<ul class="d-flex justify-content-center">
                                <li class="mr-3 "><a href="javascript:;" class="text-success action-icon"  id="approved" data-id="'.$row->rfa_id.'" data-name="'.$this->customService->ref_number($row).'"  ><i class="fa fa-check"></i></a></li>
                                <li class="mr-3 "><a href="javascript:;" class="text-secondary action-icon" data-id="'.$row->rfa_id.'"   id="view_rfa_" ><i class="fa fa-eye"></i></a></li>
                                </ul>'; 
                }

                $data[] = array(

                                    'rfa_id'               => $row->rfa_id ,
                                    'encoded_by'            => $this->userService->user_full_name($row),
                                    'name'                  => $row->client_first_name.' '.$row->client_middle_name.' '.$row->client_last_name.' '.$row->client_extension,
                                    'type_of_request_name'  => $row->type_of_request_name,
                                    'type_of_transaction'   => $row->type_of_transaction,
                                    'address'               => $row->client_purok == 0 ? $row->client_barangay : 'Purok '.$row->client_purok.' '.$row->client_barangay,
                                    'status1'               => $status1,
                                    'action1'               => $action1,
                                    'ref_number'           => $this->customService->ref_number($row),                       
                            );

        }

        return response()->json($data);
    }



    public function refer_to(Request $request){

        $where          = array('rfa_id' => $request->input('rfa_id'));
        $data           = array(
            'reffered_to'              => $request->input('reffered_to'),
            'action_taken'             => $request->input('action_taken'),
            'reffered_date_and_time'   => date('Y-m-d H:i:s', time()),
        );

        $update = $this->customRepository->update_item($this->conn, 'rfa_transactions', $where, $data);
        if ($update) {
            $item = $this->customRepository->q_get_where($this->conn_user, array('user_id' => $data['reffered_to']), 'users')->first();
            $rfa_item = $this->customRepository->q_get_where($this->conn, array('rfa_id' => $where['rfa_id']), 'rfa_transactions')->first();
            $this->actionLogService->add_pmas_rfa_action('rfa', $where['rfa_id'], 'Updated Referral to ' . $item->first_name . ' ' . $item->last_name . ' | RFA No. ' . $this->customService->ref_number($rfa_item));
            $resp = array('message' => 'Referral Updated Successfully', 'response' => true);
        } else {
            $resp = array('message' => 'Error', 'response' => false);
        }
        return response()->json($resp);
    }   

    public function view_action(Request $request){

        $data = [];
        $where = array('rfa_id'=>$request->input('id'));
        $data['action_to_be_taken'] = $this->customRepository->q_get_where($this->conn,$where,'rfa_transactions')->first()->action_to_be_taken;
        $data['rfa_id'] = $where['rfa_id']; 
        echo json_encode($data);
        
    }

    public function approved_rfa(Request $request){
    

        $where          = array('rfa_id' => $request->input('id'));
        $data           = array(
            'rfa_status'            => 'completed',
            'approved_date'   =>  Carbon::now()->format('Y-m-d H:i:s'),
        );


        $update = $this->customRepository->update_item($this->conn, 'rfa_transactions', $where, $data);
        if ($update) {
            $rfa_item = $this->customRepository->q_get_where($this->conn, array('rfa_id' => $where['rfa_id']), 'rfa_transactions')->first();
            $this->actionLogService->add_pmas_rfa_action('rfa', $where['rfa_id'], 'Approved RFA No. ' . $this->customService->ref_number($rfa_item));
            $resp = array('message' => 'Approved Successfully', 'response' => true);
        } else {
            $resp = array('message' => 'Error', 'response' => false);
        }
        return response()->json($resp);

    }


  
}
