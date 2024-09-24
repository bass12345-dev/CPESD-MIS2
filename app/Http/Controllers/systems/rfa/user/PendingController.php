<?php

namespace App\Http\Controllers\systems\rfa\user;

use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use App\Repositories\rfa\user\RFAQuery;
use App\Services\CustomService;
use App\Services\user\ActionLogService;
use App\Services\user\UserService;
use Illuminate\Http\Request;

class PendingController extends Controller
{

    protected $conn;
    protected $conn_user;
    protected $customRepository;
    protected $customService;
    protected $actionLogService;
    protected $userService;
    protected $rFAQuery;

    public function __construct(CustomRepository $customRepository, RFAQuery $rFAQuery, CustomService $customService, UserService $userService, ActionLogService $actionLogService)
    {

        $this->customRepository = $customRepository;
        $this->customService = $customService;
        $this->actionLogService = $actionLogService;
        $this->userService = $userService;
        $this->conn = config('custom_config.database.pmas');
        $this->conn_user = config('custom_config.database.users');
        $this->rFAQuery = $rFAQuery;
    }
    public function index()
    {
        $data['title'] = 'Pending';
        $data['refer_to'] = $this->customRepository->q_get_where_order($this->conn_user, 'users', array('user_type' => 'user'), 'first_name', 'desc')->get();
        return view('systems.rfa.user.pages.pending.pending')->with($data);
    }

    public function update_rfa_view($id)
    {

        $row = $this->customRepository->q_get_where($this->conn, array('rfa_id' => $id), 'rfa_transactions');
        if ($row->count()) {
            $rfa_row       = $row->first();
            $data['title'] = $this->customService->ref_number($rfa_row);
            $data['data']   = $rfa_row;
            $data['barangay'] = config('custom_config.barangay');
            $data['employment_status'] = config('custom_config.employment_status');
            $data['type_of_request'] = $this->customRepository->q_get_order($this->conn, 'type_of_request', 'type_of_request_name', 'asc')->get();
            $data['type_of_transactions'] = config('custom_config.type_of_transactions');
            $data['refer_to'] = $this->customRepository->q_get_where_order($this->conn_user, 'users', array('user_type' => 'user'), 'first_name', 'desc')->get();
            return view('systems.rfa.user.pages.update.update')->with($data);

        }else {
            echo '404';
        }

    }

    public function get_rfa_data(Request $request){
        $id = $request->input('id');
        $row = $this->rFAQuery->QueryRFAData($id);

        $data = array(
    
                    'date_time_filed'       => date('F d Y', strtotime($row->rfa_date_filed)),
                    'rfa_id '               => $row->rfa_id ,
                    'client_id'             => $row->rfa_client_id,
                    'client_name'           => $row->client_first_name.' '.$row->client_middle_name.' '.$row->client_last_name.' '.$row->client_extension,
                    'type_of_request_name'  => $row->type_of_request_name,
                    'type_of_transaction'   => $row->type_of_transaction,
                    'address'               => $row->client_purok == 0 ? $row->client_barangay : $row->client_purok.' '.$row->client_barangay,
                    'ref_number'            => $this->customService->ref_number($row),
                    'number'                => $row->number,
                    'year'                  => date('Y', strtotime($row->rfa_date_filed)),
                    'month'                 => date('m', strtotime($row->rfa_date_filed)),
                    'reffered_to'           => $row->reffered_to,
                    'tor_id'                => $row->tor_id,

        );
        return response()->json($data);
    }



    public function get_user_pending_rfa()
    {
        $data = [];
        $items = $this->rFAQuery->QueryUserPendingRFA();

        foreach ($items as $row) {

            $status1 = '';
            $action1 = '';

            if ($row->reffered_to == NULL) {
                $status1 = '<a href="javascript:;" class="btn btn-danger btn-rounded p-1 pl-2 pr-2">For Referral</a>';
            } else if ($row->reffered_to != NULL) {
                $reffered = $this->customRepository->q_get_where($this->conn_user, array('user_id' => $row->reffered_to), 'users')->first();
                $status1 = '<a href="javascript:;" class="btn btn-success btn-rounded p-1 pl-2 pr-2">Referred</a>
                                <br>' . $this->userService->user_full_name($reffered) . '<br><a href="javascript:;" class="update_referred" data-id="' . $row->rfa_id . '" data-user-id="' . $row->reffered_to . '">Update</a>';
                $action1 = ' <a class="dropdown-item " href="javascript:;" data-id="' . $row->rfa_id . '" data-status=""  id="view_rfa" ><i class="fa fa-edit" style="font-size : 20px;"></i></a>';

            }
            $action1 = ' <a class="dropdown-item " href="javascript:;" data-id="' . $row->rfa_id . '" data-status=""  id="view_rfa" ><i class="fa fa-edit" style="font-size : 20px;"></i></a>';
            $client = $this->customRepository->q_get_where($this->conn, array('rfa_client_id' => $row->client_id), 'rfa_clients')->first();

            $data[] = array(

                'rfa_id' => $row->rfa_id,
                'name' => $this->userService->user_full_name($client),
                'type_of_request_name' => $row->type_of_request_name,
                'type_of_transaction' => $row->type_of_transaction,
                'address' => 'Purok ' . $client->purok == 0 ? $client->barangay : 'Purok ' . $client->purok . ' ' . $client->barangay,
                'status1' => $status1,
                'action1' => $action1,
                'date_time_filed' => date('F d Y h:i A', strtotime($row->rfa_date_filed)),
                'ref_number' => '<a href="' . url('') . '/user/rfa/view-rfa/' . $row->rfa_id . '">' . $this->customService->ref_number($row) . '</a>'
            );
        }

        return response()->json($data);


    }

    public function get_pending_transactions_limit()
    {

        $data = [];
        $items = $this->rFAQuery->QueryRFATransactionsLimit(20);
        foreach ($items as $row) {
            $data[] = array(
                'rfa_id ' => $row->rfa_id,
                'ref_number' => $this->customService->ref_number($row),
                'rfa_date_filed' => date('M,d Y', strtotime($row->rfa_date_filed)) . ' ' . date('h:i a', strtotime($row->rfa_date_filed)),
                'name' => $this->userService->user_full_name($row)

            );
        }

        return response()->json($data);


    }



    public function update_referral(Request $request)
    {

        $referred_to = $request->input('refer_to_id');
        $rfa_id = $request->input('rfa_id');

        $where = array('rfa_id' => $rfa_id);
        $data = array(
            'reffered_to' => $referred_to,
        );

        $update = $this->customRepository->update_item($this->conn, 'rfa_transactions', $where, $data);

        if ($update) {
            $item = $this->customRepository->q_get_where($this->conn_user, array('user_id' => $referred_to), 'users')->first();
            $rfa_item = $this->customRepository->q_get_where($this->conn, array('rfa_id' => $rfa_id), 'rfa_transactions')->first();
            $this->actionLogService->add_pmas_rfa_action('rfa', $rfa_id, 'Updated Referral to ' . $item->first_name . ' ' . $item->last_name . ' | RFA No. ' . $this->customService->ref_number($rfa_item));
            $resp = array('message' => 'Referral Updated Successfully', 'response' => true);
        } else {
            $resp = array('message' => 'Error', 'response' => false);
        }
        return response()->json($resp);

    }


    public function count_pending_rfa(){

        $count = 0;

        if (session('user_type') == 'admin') {
    
            $where = array('rfa_status' => 'pending');
            $count = $this->customRepository->q_get_where($this->conn,$where,'rfa_transactions')->count(); 
           
        }else if (session('user_type') == 'user') {
            
            $where = array('rfa_status' => 'pending','rfa_created_by' => session('user_id'));
            $count = $this->customRepository->q_get_where($this->conn,$where,'rfa_transactions')->count();
        }
    
        return $count;

    }

    public function count_reffered_rfa(){

        $where = array('rfa_status' => 'pending','reffered_to' => session('user_id'));
        $count = $this->customRepository->q_get_where($this->conn,$where,'rfa_transactions')->count();
        echo $count;

    }



}
