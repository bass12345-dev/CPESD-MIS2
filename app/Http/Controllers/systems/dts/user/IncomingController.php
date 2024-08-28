<?php

namespace App\Http\Controllers\systems\dts\user;

use App\Http\Controllers\Controller;
use App\Repositories\dts\DtsQuery;
use App\Services\dts\user\DocumentService;
use Illuminate\Http\Request;
use League\CommonMark\Node\Block\Document;

class IncomingController extends Controller
{
    protected $dtsQuery;
    protected $documentService;
    private $user_type                  = 'user';
    public function __construct(DtsQuery $dtsQuery, DocumentService $documentService)
    {
        $this->dtsQuery = $dtsQuery;
        $this->documentService = $documentService;
    }
    public function index(){
        $data['title']          = 'Incoming Documents';
        return view('systems.dts.user.pages.incoming.incoming')->with($data);
    }

    

    
    
    //CREATE
    public function receive_documents(Request $request)
    {
        $items = $request->input('id')['items'];
        if (is_array($items)) {

            foreach ($items as $row) {
                $x = explode('-', $row);
                $history_id = $x[0];
                $tracking_number = $x[1];
                $resp = $this->documentService->received_process($history_id,$tracking_number,$this->user_type); 
            }
        } else {
            $resp = array('message' => 'Error', 'response' => false);
        }
        return response()->json($resp);
    }
    //READ
    public function get_incoming_documents(){

        $data = [];
        $rows = $this->dtsQuery->get_incoming_documents();
        $i = 1;
        foreach ($rows as $key) {

          

            $data[] = array(
                    'number'            => $i++,
                    'his+tn'            => $key->history_id.'-'.$key->tracking_number,
                    'tracking_number'   => $key->tracking_number,
                    'document_name'     => $key->document_name,
                    'type_name'         => $key->type_name,
                    'released_date'     => date('M d Y - h:i a', strtotime($key->release_date)) ,
                    'from'              => $key->name,
                    'document_id'       => $key->document_id,
                    'history_id'        => $key->history_id,
                    'remarks'           => $key->remarks,
                    'a'                 => $key->user_type == 'admin' ? true : false
            );
        }

        return response()->json($data);

    }

    //UPDATE
    //DELETE

}
