<?php

namespace App\Http\Controllers\systems\dts\user;

use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use App\Repositories\dts\DtsQuery;
use App\Services\dts\user\DocumentService;
use App\Services\user\ActionLogService;
use Illuminate\Http\Request;

class MyDocumentsController extends Controller
{
   
    protected $conn;
    protected $customRepository;
    protected $documentService;
    protected $document_types_table;       
    protected $office_table;          
    protected $actionLogService;    
    protected $dtsQuery; 
    public function __construct(CustomRepository $customRepository, DocumentService $documentService,ActionLogService $actionLogService,DtsQuery $dtsQuery){
        $this->conn                 = config('custom_config.database.dts');
        $this->customRepository     = $customRepository;
        $this->documentService      = $documentService;
        $this->actionLogService     = $actionLogService;
        $this->dtsQuery             = $dtsQuery;
        $this->document_types_table = "document_types";
        $this->office_table         = 'offices';
     
    }

    
 

    public function index(){
        $data['title']          = 'My Documents';
        $data['document_types'] = $this->customRepository->q_get_order($this->conn,$this->document_types_table, 'type_name', 'asc')->get();
        $data['offices']        = $this->customRepository->q_get_order($this->conn,$this->office_table, 'office', 'asc')->get();
        return view('systems.dts.user.pages.my_documents.my_documents')->with($data);
    }

    public function get_my_documents(){

        $items = $this->documentService->get_my_documents();
        return response()->json($items);
    }

    public function  update_document(Request $request){
     
        $id = $request->input('t_number');
        $items = array(

            'document_name'             => $request->input('document_name'),
            'doc_type'                  => $request->input('document_type'),
            'document_description'      => trim($request->input('description')),
            'origin'                    => $request->input('origin')

        );

        $update = $this->customRepository->update_item($this->conn,'documents', array('tracking_number' => $id), $items);
        if ($update) {
            $query_row = $this->documentService->document_data(array('tracking_number' => $id));
            $this->actionLogService->dts_add_action('Updated Document No. ' . $id, 'user',$query_row->document_id);
            $data = array('message' => 'updated Succesfully', 'response' => true);
        } else {

            $data = array('message' => 'Something Wrong/No Changes Apply ', 'response' => false);
        }
        return response()->json($data);
    }


    public function search(){
        $search = trim($_GET['q']);
        $docs = $this->dtsQuery->search($search);
        return response()->json($docs);
    }
}
