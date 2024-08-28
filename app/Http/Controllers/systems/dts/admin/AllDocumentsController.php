<?php

namespace App\Http\Controllers\systems\dts\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Services\dts\admin\DocumentService;
use App\Services\user\ActionLogService;
use Carbon\Carbon;

class AllDocumentsController extends Controller
{
    protected $conn;
    protected $customRepository;
    protected $documentService;
    protected $actionLogService;
    protected $final_actions_table;
    public function __construct(CustomRepository $customRepository,DocumentService $documentService, ActionLogService $actionLogService){
        $this->conn                 = config('custom_config.database.dts');
        $this->customRepository     = $customRepository;
        $this->documentService      = $documentService;
        $this->actionLogService     = $actionLogService;
        $this->final_actions_table  = "final_actions";
     
    }
    public function index(){
        $data['title']              = 'All Documents';
        $data['final_actions']      = $this->customRepository->q_get($this->conn,$this->final_actions_table)->get();
        $data['current']            = Carbon::now()->year.'-'.Carbon::now()->month;
        return view('systems.dts.admin.pages.all_documents.all_documents')->with($data);
    }

    //CREATE
    public function complete_documents(Request $request){

        $items           = $request->input('c_t_number');
        $remarks         = $request->input('remarks2');
        $final_action    = $request->input('final_action_taken');
        $array           = explode(',',$items);
        $user_type       = $request->input('user_type');
        
        foreach ($array as $row) {

            $x                  = explode('-', $row);
            $history_id         = $x[0];
            $tracking_number    = $x[1];
            $resp               = $this->documentService->complete_process($remarks,$final_action,$history_id,$tracking_number,$user_type);
           
        }

        return response()->json($resp);

    }


    //READ
    public function get_all_documents(){

        $month = '';
        $year = '';
        if(isset($_GET['date'])){
            $month =   date('m', strtotime($_GET['date']));
            $year =   date('Y', strtotime($_GET['date']));
        }
        
        $data = $this->documentService->get_all_document_process($month,$year);
        return response()->json($data);

    }
    //UPDATE
    public function cancel_documents(Request $request){

        $ids            = $request->input('document_ids');
        $reason         = $request->input('reason');
        $id             = explode(",", $ids);
        $message        = '';
        $arr = [];
        foreach ($id as $row) {
            $items = array(
                            'doc_status'         => 'cancelled',
                            'note'               => $reason
                        );
            $check  = $this->customRepository->q_get_where($this->conn,array('document_id' => $row),'documents')->first();
            if($check->doc_status != 'completed'){
                            $this->customRepository->update_item($this->conn,'documents', array('document_id' => $row), $items);
                            $this->actionLogService->dts_add_action('Canceled Document No. '.$check->tracking_number,'admin',$row);
                        }else {
                            array_push($arr, $check->document_id);
                        }

        }

        $message = count($arr) > 0 ? " Canceled Successfully | Some documents is cannot be cancelled because it's already completed or canceled already" : 'Canceled Succesfully';
        $data = array('message' => $message, 'response' => true);
        return response()->json($data);

    }

    //DELETE
    public function delete_documents(Request $request){
        
        $id = $request->input('id')['id'];
        if (is_array($id)) {
            foreach ($id as $row) {
                $delete                   = $this->customRepository->q_get_where($this->conn,array('document_id' => $row),'documents');
                $tracking_number          = $delete->first()->tracking_number;
                $document_id =              $delete->first()->document_id;
                $delete->delete();
               $this->actionLogService->dts_add_action('Deleted Document No. '.$tracking_number,'admin',$document_id);
                $this->customRepository->delete_item($this->conn,'history', array('t_number' => $tracking_number));
                $this->customRepository->delete_item($this->conn,'outgoing_documents', array('doc_id' => $document_id));
            }

            $data = array('message' => 'Deleted Succesfully', 'response' => true);
        } else {
            $data = array('message' => 'Error', 'response' => false);
        }



        return response()->json($data);
    }

    public function revert_document(Request $request){

        $tracking_number = $request->input('t');
        $items = array(
            'doc_status'         => 'pending',
        );
        $update = $this->customRepository->update_item($this->conn,'documents', array('tracking_number' => $tracking_number), $items);
        if ($update) {
            $query_row = $this->customRepository->q_get_where($this->conn,array('tracking_number' => $tracking_number),'documents')->first();
            $this->actionLogService->dts_add_action('Reverted Document No. '.$query_row->tracking_number,'admin',$query_row->document_id);
            $update = $this->customRepository->update_item($this->conn,'documents', array('document_id' => $query_row->document_id), $items);
            $data = array('message' => 'Reverted Succesfully', 'response' => true);
        } else {

            $data = array('message' => 'Something Wrong/No Changes Apply ', 'response' => false);
        }
        return response()->json($data);

    }



}
