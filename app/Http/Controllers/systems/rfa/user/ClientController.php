<?php

namespace App\Http\Controllers\systems\rfa\user;

use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use App\Repositories\rfa\user\RFAQuery;
use App\Services\CustomService;
use App\Services\user\ActionLogService;
use App\Services\user\UserService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class ClientController extends Controller
{

    protected $conn;
    protected $customRepository;
    protected $customService;
    protected $userService;
    protected $actionLogService;
    protected $rFAQuery;

    public function __construct(CustomRepository $customRepository, RFAQuery $rFAQuery, CustomService $customService, UserService $userService, ActionLogService $actionLogService)
    {

        $this->customRepository = $customRepository;
        $this->customService = $customService;
        $this->actionLogService = $actionLogService;
        $this->userService = $userService;
        $this->conn = config('custom_config.database.pmas');
        $this->rFAQuery = $rFAQuery;
    }

    public function index(){
        $data['title']                      = 'My Clients';
        $data['barangay']                   = config('custom_config.barangay');
        $data['employment_status']          = config('custom_config.employment_status'); 
        return view('systems.rfa.user.pages.clients.clients')->with($data);
    }


    public function search_name(Request $request)
    {
        $data = [];
        $search = $request->input('first_name') . ' ' . $request->input('last_name');

        $items = $this->rFAQuery->search_client($search);

        foreach ($items as $row) {

            $data[] = array(

                'rfa_client_id' => $row->rfa_client_id,
                'first_name' => $row->first_name,
                'middle_name' => $row->middle_name,
                'last_name' => $row->last_name,
                'extension' => $row->extension,
                'address' => $row->purok == 0 ? $row->barangay : 'Purok ' . $row->purok . ' ' . $row->barangay,
                'contact_number' => $row->contact_number,
                'age' => $row->age,
                'employment_status' => $row->employment_status,

            );
        }

        return response()->json($data);

    }

    public function update_rfa(Request $request){
        
        $where = array('rfa_id' => $request->input('update_rfa_id'));

        $data = array(

            'client_id'           => $request->input('client_id'),
            'tor_id'              => $request->input('type_of_request'),
            'type_of_transaction' => $request->input('type_of_transaction'),
            'reffered_to'         => $request->input('refer_to_id') == '' ? NULL : $request->input('refer_to_id'),
        );

        $update             = $this->customRepository->update_item($this->conn,'rfa_transactions',$where,$data);
        if ($update) {
            $rfa_item       = $this->customRepository->q_get_where($this->conn,array('rfa_id' =>  $where['rfa_id']),'rfa_transactions')->first();
            $this->actionLogService->add_pmas_rfa_action('rfa',$where['rfa_id'],'Updated RFA No. '. $this->customService->ref_number($rfa_item));
            $resp = array('message' => 'RFA No. '.$this->customService->ref_number($rfa_item).' Accomplished Successfully', 'response' => true);
        } else {
            $resp = array('message' => 'Error', 'response' => false);
        }
        return response()->json($resp);


    }
    public function add_rfa(Request $request)
    {


        $item = array(
            'rfa_tracking_code'         => mt_rand() . date('Ymd', time()) . $request->input('reference_number'),
            'number'                    => $request->input('reference_number'),
            'rfa_date_filed'            => Carbon::now()->format('Y-m-d H:i:s'),
            'type_of_transaction'       => $request->input('type_of_transaction'),
            'tor_id'                    => $request->input('type_of_request'),
            'client_id'                 => $request->input('client_id'),
            'rfa_created_by'            => session()->get('user_id'),
            'reffered_to'               => $request->input('refer_to_id') == '' ? NULL : $request->input('refer_to_id'),
            'rfa_status'                => 'pending'
        );
      
        $array_where = array(
            'rfa_date_filed' => date('Y-m', time()),
            'number' => $item['number']
        );
        $verify = $this->customRepository->q_get_where($this->conn,$array_where,'rfa_transactions')->count();

        if (!$verify) {
            $add = DB::connection($this->conn)->table('rfa_transactions')->insertGetId($item);
            $row = $this->customRepository->q_get_where($this->conn,  array('rfa_id' => $add),'rfa_transactions')->first();
            if ($add) {
                $this->actionLogService->add_pmas_rfa_action('rfa',$add,'Approved RFA No. '. $this->customService->ref_number($row));
                $resp = array(
                    'message' => 'RFA Created Successfully',
                    'response' => true
                );

            } else {

                $resp = array(
                    'message' => 'Error',
                    'response' => false
                );
            }

        } else {


            $resp = array(
                'message' => 'Error Duplicate Reference NO',
                'response' => false
            );
        }

        return response()->json($resp);
    }


    public function add_client(Request $request)
    {
        $item = array(
            'rfa_client_added_by'       => session('user_id'),
            'first_name'                => $request->input('first_name'),
            'middle_name'               => ($request->input('middle_name') == '') ? '' : $request->input('middle_name'),
            'last_name'                 => $request->input('last_name'),
            'extension'                 => ($request->input('extension') == '') ? '' : $request->input('extension'),
            'purok'                     => $request->input('purok'),
            'barangay'                  => $request->input('barangay'),
            'contact_number'            => $request->input('contact_number'),
            'age'                       => $request->input('age'),
            'gender'                    => $request->input('gender'),
            'employment_status'         => $request->input('employment_status'),
            'rfa_client_created'        => Carbon::now()->format('Y-m-d H:i:s'),


        );
        $verify = $this->customRepository->q_get_where($this->conn, array(
            'first_name' => $item['first_name'],
            'middle_name' => $item['middle_name'],
            'last_name' => $item['last_name']
        ), 'rfa_clients')->count();

        if ($verify > 0) {
            $data = array(
                'message' => 'Duplicate Name',
                'response' => false
            );
        } else {
            $result = $this->customRepository->insert_item($this->conn, 'rfa_clients', $item);
            if ($result) {
                $data = array(
                    'message' => 'Data Saved Successfully',
                    'response' => true
                );
            } else {

                $data = array(
                    'message' => 'Error',
                    'response' => false
                );
            }

        }

        return response()->json($data);

    }


    public function get_my_clients(){
        
        $item = $this->rFAQuery->QueryMyClients();
        $data = [];
        foreach ($item as $row) {
            
                $data[] = array(

                        'rfa_client_id'     => $row->rfa_client_id,
                        'address'           => $row->client_purok == 0 ? $row->client_barangay : 'Purok '.$row->client_purok.' '.$row->client_barangay,
                        'contact_number'    => $row->client_contact_number,
                        'age'               => $row->client_age,
                        'employment_status' => $row->client_employment_status,
                        'full_name'         => $row->client_first_name.' '.$row->client_middle_name.' '.$row->client_last_name.' '.$row->client_extension,
                        'gender'            => $row->client_gender == null ? '' : $row->client_gender,
                        'count'             => $row->count
                        
                );
        }

        return response()->json($data);
    }


}
