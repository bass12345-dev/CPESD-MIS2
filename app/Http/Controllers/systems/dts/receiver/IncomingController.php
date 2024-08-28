<?php

namespace App\Http\Controllers\systems\dts\receiver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Repositories\dts\ReceiverDtsQuery;
use App\Services\dts\admin\DashboardService;
use App\Services\user\UserService;
use Carbon\Carbon;

class IncomingController extends Controller
{
    protected $conn;
    protected $customRepository;
    protected $dashboardService;
    protected $receiverDtsQuery;
    protected $userService;
    public function __construct(CustomRepository $customRepository, DashboardService $dashboardService, ReceiverDtsQuery $receiverDtsQuery, UserService $userService){
        $this->conn                 = config('custom_config.database.dts');
        $this->customRepository     = $customRepository;
        $this->dashboardService     = $dashboardService;
        $this->receiverDtsQuery     = $receiverDtsQuery;
        $this->userService          = $userService;
     
    }   

    public function index(){
        $data['title']              = 'Incoming Documents';
        $data['final_actions']      = $this->customRepository->q_get($this->conn,'final_actions')->get();
        return view('systems.dts.receiver.pages.incoming.incoming')->with($data);
    }


    public function get_receiver_incoming_documents(){
        $data = [];

        $rows = $this->receiverDtsQuery->get_receiver_incoming_documents();
        $i = 1;
       foreach ($rows as $key) {

          

            $data[] = array(
                    'number'            => $i++,
                    'data'              => $key->history_id.','.$key->tracking_number,
                    'tracking_number'   => $key->tracking_number,
                    'document_name'     => $key->document_name,
                    'type_name'         => $key->type_name,
                    'released_date'     => date('M d Y - h:i a', strtotime($key->release_date)) ,
                    'from'              => $this->userService->user_full_name($key),
                    'document_id'       => $key->document_id,
                    'history_id'        => $key->history_id,
                    'remarks'           => $key->remarks,
                    'a'                 => $key->user_type == 'admin' ? true : false,
                    'note'              => empty($key->note) ? 'Empty Note' : $key->note
            );
        }

        return response()->json($data);
    }


    public function get_receiver_incoming(){
        $id = session('user_id');
        $count = $this->customRepository->q_get_where($this->conn, array('user2' => $id, 'received_status' => NULL, 'status' => 'torec', 'release_status' => NULL, 'to_receiver' => 'yes'),'history')->count();
        return $count;

    }

    





}
