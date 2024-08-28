<?php

namespace App\Http\Controllers\systems\dts\user;

use App\Http\Controllers\Controller;
use App\Repositories\dts\DtsQuery;
use App\Services\dts\user\DocumentService;
use Illuminate\Http\Request;
use League\CommonMark\Node\Block\Document;
use Carbon\Carbon;
use App\Repositories\CustomRepository;
use App\Services\user\ActionLogService;
class OutgoingController extends Controller
{
    protected $dtsQuery;
    protected $documentService;
    protected $customRepository;
    protected $conn;
    protected $actionLogService;
    private $user_type                  = 'user';

    public function __construct(DtsQuery $dtsQuery, DocumentService $documentService, CustomRepository $customRepository, ActionLogService $actionLogService)
    {
        $this->conn                 = config('custom_config.database.dts');
        $this->dtsQuery             = $dtsQuery;
        $this->documentService      = $documentService;
        $this->customRepository     = $customRepository;
        $this->actionLogService     = $actionLogService;
    }
    public function index(){
        $data['title']              = 'Outgoing Documents';
        $data['offices']            = $this->customRepository->q_get_order($this->conn,'offices','office','asc')->get(); 
        return view('systems.dts.user.pages.outgoing.outgoing')->with($data);
    }

    

    //CREATE
    public function outgoing_documents(Request $request){

        $items          = $request->input('history_track2');
        $note           = $request->input('note');
        $office         = $request->input('office');
        $array          = explode(',',$items);

        foreach ($array as $row) {

            $x                  = explode('-', $row);
            $history_id         = $x[0];
            $tracking_number    = $x[1];
            $resp               = $this->documentService->outgoing_documents_process($note,$office,$history_id,$tracking_number);
            
           
        }
        return response()->json($resp);

    }

    public function received_from_outgoing(Request $request){


        $items = $request->input('id')['items'];

        if (is_array($items)) {

            foreach ($items as $row) {

                $x                  = explode('-', $row);
                $outgoing_id        = $x[0];
                $document_id        = $x[1];

                $doc_info = array(
                    'doc_status' => 'pending',
                 );
                $outgoing_info = array(
                    'status'                    => 'return',
                    'outgoing_date_received'    => Carbon::now()->format('Y-m-d H:i:s'),
                 );

                $r = $this->customRepository->q_get_where($this->conn, array('document_id' => $document_id),'documents')->first();
                $where1 = array('document_id' => $document_id);
                $where2 = array('outgoing_id' => $outgoing_id);
                $update_outgoing = $this->customRepository->update_item($this->conn,'outgoing_documents',$where2,$outgoing_info);
                $update_document = $this->customRepository->update_item($this->conn,'documents',$where1,$doc_info);
                $this->actionLogService->dts_add_action($action = 'Received Document From Outgoing Document No. ' . $r->tracking_number, $user_type = 'user', $_id = $r->document_id);
                $resp = array('message' => 'Received Successfully', 'response' => true);
                
            }

        } else {
            $resp = array('message' => 'Error', 'response' => false);
        }
        return response()->json($resp);

    }


    
    //READ
    public function get_outgoing_documents(){

        $items = $this->dtsQuery->get_outgoing_documents();
        $i = 1;
        $data = [];
        foreach ($items as $key) {

            $data[] = array(
                'number'            => $i++,
                'outgoing_id'       => $key->outgoing_id,
                'doc_id'            => $key->outgoing_id.'-'.$key->doc_id,
                'tracking_number'   => $key->tracking_number,
                'document_name'     => $key->document_name,
                'name'              => $key->first_name.' '.$key->middle_name.' '.$key->last_name.' '.$key->extension,
                'type_name'         => $key->type_name,
                'remarks'           => $key->remarks,
                'office'            => $key->office,
                'office_id'         => $key->office_id,
                'outgoing_date'     => date('M d Y - h:i a', strtotime($key->outgoing_date))
            );
          
        }

        return response()->json($data);
    }
    //UPDATE
    public function update_outgoing_documents(Request $request){
        
        $outgoing_id    = $request->input('outgoing_id');
        $office_id      = $request->input('office');
        $remarks        = $request->input('remarks');
        $where          = array('outgoing_id'=> $outgoing_id);
        $info = array(
            'remarks'   => $remarks,
            'off_id'    => $office_id
        );

        $update     = $this->customRepository->update_item($this->conn,'outgoing_documents',$where,$info);
          if ($update) {
                $data = array('message' => 'Updated Successfully' , 'response' => true );
            }else {
                $data = array('message' => 'Something Wrong/No Changes Apply' , 'response' => false );
            }
        return response()->json($data);
    }
    //DELETE



}
