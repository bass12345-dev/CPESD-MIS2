<?php

namespace App\Http\Controllers\systems\dts\user;

use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use App\Repositories\dts\DtsQuery;
use App\Services\dts\user\DocumentService;
use Illuminate\Http\Request;
use League\CommonMark\Node\Block\Document;

class ReceivedController extends Controller
{
    protected $dtsQuery;
    protected $documentService;
    protected $customRepository;
    private $user_type                  = 'user';
    protected $conn;
    protected $conn_user;
    protected $user_table;
    public function __construct(DtsQuery $dtsQuery, DocumentService $documentService, CustomRepository $customRepository)
    {
        $this->conn                 = config('custom_config.database.dts');
        $this->conn_user            = config('custom_config.database.users');
        $this->dtsQuery             = $dtsQuery;
        $this->documentService      = $documentService;
        $this->customRepository     = $customRepository;
        $this->user_table           = 'users';
        
    }
    public function index(){
        $data['title']              = 'Received Documents';
        $data['users']              = $this->customRepository->q_get_where($this->conn_user,array('user_status' => 'active'),$this->user_table)->get();
        $data['offices']            = $this->customRepository->q_get_order($this->conn,'offices','office','asc')->get(); 
        $data['final_actions']      = $this->customRepository->q_get($this->conn,'final_actions')->get();
        return view('systems.dts.user.pages.received.received')->with($data);
    }

    


     //CREATE
        //FORWARD
        public function forward_documents(Request $request){

            $items      = $request->input('history_track1');
            $remarks    = $request->input('remarks1');
            $forward    = $request->input('forward1');
            $user_id    = session('user_id');
            $array      = explode(',',$items);
            
            foreach ($array as $row) {

                $x                  = explode('-', $row);
                $history_id         = $x[0];
                $tracking_number    = $x[1];
                $resp               = $this->documentService->forward_process($remarks,$forward,$user_id,$history_id,$tracking_number,$this->user_type);
            
            }

            return response()->json($resp);
        


        }
      //RECEIVED ERROR
        public function received_errors(Request $request){
            
            $items = $request->input('id')['items'];

            if (is_array($items)) {

                foreach ($items as $row) {

                    $x = explode('-', $row);

                    $history_id = $x[0];
                    $tracking_number = $x[1];
                    $resp = $this->documentService->received_error_process($history_id,$tracking_number);

                }
            }
            return response()->json($resp);
        }
     //READ
     public function get_received_documents(){
        $data = [];
        $rows = $this->dtsQuery->get_received_documents();
        $i = 1;
        foreach ($rows as $value => $key) {
 
          
             $data[] = array(
                     'his_tn'            => $key->history_id.'-'.$key->tracking_number,
                     'tracking_number'   => $key->tracking_number,
                     't_'                => $key->tracking_number,
                     'document_name'     => $key->document_name,
                     'type_name'         => $key->type_name,
                     'received_date'     => date('M d Y - h:i a', strtotime($key->received_date)) ,
                     'history_id'        => $key->history_id,
                     'document_id'       => $key->document_id,
                     'a'                 => $key->user_type == 'admin' ? false : true,
                     'remarks'           => $key->remarks,
                     'number'            => $i++
             );
         }
 
        return response()->json($data);
 
     }
     //UPDATE
     //DELETE



}
