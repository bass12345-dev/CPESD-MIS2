<?php

namespace App\Services\dts\admin;

use App\Repositories\CustomRepository;
use App\Repositories\dts\AdminDtsQuery;
use App\Repositories\dts\DtsQuery;
use App\Services\user\ActionLogService;
use App\Services\CustomService;
use App\Services\user\UserService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DocumentService
{

    protected $conn;
    protected $conn_user;
    protected $customRepository;
    protected $documents_table;
    protected $history_table;
    protected $outgoing_table;
    protected $user_table;
    protected $adminDtsQuery;
    protected $customService;
    protected $actionLogService;
    protected $userService;
    public function __construct(CustomRepository $customRepository, AdminDtsQuery $adminDtsQuery, CustomService $customService, ActionLogService $actionLogService, UserService $userService)
    {
        $this->conn = config('custom_config.database.dts');
        $this->conn_user = config('custom_config.database.users');
        $this->customRepository = $customRepository;
        $this->customService = $customService;
        $this->actionLogService = $actionLogService;
        $this->userService      = $userService;
        $this->adminDtsQuery = $adminDtsQuery;
        $this->documents_table = 'documents';
        $this->history_table = 'history';
        $this->outgoing_table = 'outgoing_documents';
        $this->user_table = 'users';
    }

    public function get_all_document_process($month, $year)
    {


        if ($month == '' && $year == '') {
            $items = $this->adminDtsQuery->QueryAllDocuments();
        } else {
            $items = $this->adminDtsQuery->QueryDocumentsByMonth($month, $year);
        }

        $data = [];
        $i = 1;
        foreach ($items as $key) {
            $where = array('t_number' => $key->tracking_number);
            $delete_button = $this->customRepository->q_get_where($this->conn, $where, $this->history_table)->count() > 1 ? true : false;
            $status = $this->customService->check_status($key->doc_status);
            $history = $this->customRepository->q_get_where_order($this->conn, $this->history_table, $where, 'history_id', 'desc');
            $is_existing = $history->count();
            $origin = $key->origin == NULL ? '-' : $key->origin;
            $history_id = $is_existing == 0 ? '' : $history->first()->history_id;
            $data[] = array(
                'number'                => $i++,
                'tracking_number'       => $key->tracking_number,
                'document_name'         => $key->document_name,
                'type_name'             => $key->type_name,
                'created'               => date('M d Y - h:i a', strtotime($key->created)),
                'a'                     => $delete_button,
                'document_id'           => $key->document_id,
                'history_id'            => $history_id,
                'error'                 => $is_existing == 0 ? 'text-danger' : '',
                'user_id'               => $key->u_id,
                'created_by'            => $this->userService->user_full_name($key),
                'is'                    => $status,
                'history_status'        => $key->doc_status,
                'data'              =>  $key->document_name.'~'.
                                        $key->tracking_number.'~'.
                                        $key->type_name.'~'.
                                        date('M d Y - h:i a', strtotime($key->created)).'~'.
                                        $this->userService->user_full_name($key).'~'.
                                        $key->destination_type.'~'.
                                        $origin.'~'.
                                        $key->document_description.'~'.
                                        $key->document_id.'~'.
                                        $history_id,

            );
        }


        return $data;
    }


     //Complete Documents
     public function complete_process($remarks,$final_action,$history_id,$tracking_number,$user_type){

        $hs                 = $this->customRepository->q_get_where_order($this->conn,$this->history_table,array('history_id' => $history_id),'history_id','desc')->first();
        $user_row           = $this->customRepository->q_get_where($this->conn_user, array('user_id' => session('user_id')),'users')->first();

        if($user_row->user_id == 8 || $user_row->user_id == 13 || $user_row->is_receiver === 'yes' || $user_row->user_id == 24 || $user_row->user_id == 9 ){

        $where              = array('history_id' => $history_id);
        $data               = array(
                            'status'            => 'received',
                            'received_status'   => 1,
                            'received_date'     =>  $hs->received_date == NULL ?   Carbon::now()->format('Y-m-d H:i:s') : $hs->received_date,
                            'release_status'    => 1,
                            'release_date'      =>  $hs->release_date == NULL ?   Carbon::now()->format('Y-m-d H:i:s')  : $hs->release_date,
        );
        $update             = $this->customRepository->update_item($this->conn,$this->history_table,$where,$data);

        if($update){

        $info = array(
            't_number'              => $tracking_number,
            'user1'                 => $user_row->user_id,
            'office1'               => $user_row->off_id,
            'user2'                 => $user_row->user_id,
            'office2'               => $user_row->off_id,
            'received_status'       => 1,
            'received_date'         => Carbon::now()->format('Y-m-d H:i:s') ,
            'release_status'        => NULL,
            'to_receiver'           => 'no',
            'release_date'          => Carbon::now()->format('Y-m-d H:i:s') ,
            'status'                => 'completed',
            'final_action_taken'    => $final_action,
            'remarks'               => $remarks

        );

        $add1 = $this->customRepository->insert_item($this->conn,$this->history_table, $info);

        if ($add1) {
            $query_row      = $this->customRepository->q_get_where($this->conn,array('tracking_number'=> $tracking_number),$this->documents_table)->first();
            $this->customRepository->update_item($this->conn,$this->documents_table,array('tracking_number' =>  $tracking_number), array('doc_status' => 'completed','completed_on'=> Carbon::now()->format('Y-m-d H:i:s')));
            $this->actionLogService->dts_add_action('Completed Document No. '.$query_row->tracking_number,$user_type,$query_row->document_id);
            $data = array('message' => 'Completed Succesfully', 'response' => true);
        } else {

            $data = array('message' => 'Something Wrong', 'response' => false);

        }

        }else {
            $data = array('message' => 'Something Wrong', 'response' => false);
        }

    }else {
        $data = array('message' => 'Sorry !!!! You are not Authorized to use this action', 'response' => false);
    }


        return $data;
    }


}
