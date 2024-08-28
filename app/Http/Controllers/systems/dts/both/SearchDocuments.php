<?php

namespace App\Http\Controllers\systems\dts\both;

use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use App\Repositories\dts\DtsQuery;
use App\Services\dts\user\DocumentService;
use Illuminate\Http\Request;

class SearchDocuments extends Controller
{
    protected $dtsQuery;
    protected $documentService;
    protected $customRepository;
    protected $conn;
    private $user_type                  = 'user';
    public function __construct(DtsQuery $dtsQuery, DocumentService $documentService, CustomRepository $customRepository)
    {
        $this->conn                 = config('custom_config.database.dts');
        $this->dtsQuery = $dtsQuery;
        $this->documentService = $documentService;
        $this->customRepository  = $customRepository;
    }
    public function index(Request $request){
        $data['title']          = 'Search Documents';
        $segments = $request->segments();
        if($segments[0] == 'user') {
             return view('systems.dts.user.pages.search_documents.search_documents')->with($data);
        }else if($segments[0] == 'admin') {
            return view('systems.dts.admin.pages.search_documents.search_documents')->with($data);
        }
    }

    public function view_document(Request $request){
        $tn                         = $_GET['tn'];
        $check                      = $this->customRepository->q_get_where($this->conn,array('tracking_number' => $tn),'documents')->count();
        if ($check > 0) {
            $data['title']                  = 'Document #' . $tn;
            $data['doc_data']               = $this->documentService->get_document_data($tn);
            $data['history']                = $this->documentService->get_document_history($tn);
            $data['outgoing_history']       = $this->dtsQuery->get_outgoing_history($tn);
            $segments = $request->segments();
            if($segments[0] == 'user') {
                return view('systems.dts.user.pages.view.view')->with($data);
            }else if($segments[0] == 'admin') {
                return view('systems.dts.admin.pages.view.view')->with($data);
            }

        }else {
            echo '<script>alert("Tracking Number Not Found")
                history.back();
         </script>';

        }



       
    }



}
