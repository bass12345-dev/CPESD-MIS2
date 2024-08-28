<?php

namespace App\Http\Controllers\systems\dts\receiver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Repositories\dts\ReceiverDtsQuery;
use App\Services\CustomService;
use App\Services\dts\admin\DashboardService;
use App\Services\user\UserService;
use Carbon\Carbon;

class FindDocumentController extends Controller
{
    protected $conn;
    protected $customRepository;
    protected $dashboardService;
    protected $receiverDtsQuery;
    protected $userService;
    protected $customService;
    public function __construct(CustomRepository $customRepository, DashboardService $dashboardService, ReceiverDtsQuery $receiverDtsQuery, UserService $userService, CustomService $customService){
        $this->conn                 = config('custom_config.database.dts');
        $this->customRepository     = $customRepository;
        $this->dashboardService     = $dashboardService;
        $this->receiverDtsQuery     = $receiverDtsQuery;
        $this->userService          = $userService;
        $this->customService        = $customService;
     
    }   


    public function index(){
        $data['title']      = 'Find Documents';
        $data['final_actions']      = $this->customRepository->q_get($this->conn,'final_actions')->get();
        return view('systems.dts.receiver.pages.find_document.find_document')->with($data);
    }
    

    public function search_documents(){
        $search = trim($_GET['query']);
       
        $rows = $this->receiverDtsQuery->search($search);
        $data = [];
        $i = 1;
        
       foreach ($rows as $key) {
        $history_row = $this->customRepository->q_get_where_order($this->conn,'history',array('t_number' => $key->tracking_number),'history_id','desc')->first();
    
            $data[] = array(
                    'number'            => $i++,
                    'data'              => $history_row->history_id.','.$key->tracking_number,
                    'tracking_number'   => $key->tracking_number,
                    'document_name'     => $key->document_name,
                    'type_name'         => $key->type_name,
                    'from'              => $this->userService->user_full_name($key),
                    'document_id'       => $key->document_id,
                    'history_id'        => $history_row->history_id,
                    'note'              => empty($key->note) ? 'Empty Note' : $key->note,
                    'doc_status'        => $this->customService->check_status($key->doc_status)
            );
        }

        return response()->json($data);

    }




}
