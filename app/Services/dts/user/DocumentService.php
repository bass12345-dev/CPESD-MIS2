<?php

namespace App\Services\dts\user;

use App\Repositories\CustomRepository;
use App\Repositories\dts\DtsQuery;
use App\Services\user\ActionLogService;
use App\Services\CustomService;
use App\Services\user\UserService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use DateTime;

class DocumentService
{

    protected $conn;
    protected $conn_user;
    protected $customRepository;
    protected $documents_table;
    protected $history_table;
    protected $outgoing_table;
    protected $user_table;
    protected $dtsQuery;
    protected $customService;
    protected $actionLogService;
    protected $userService;

    public function __construct(CustomRepository $customRepository, DtsQuery $dtsQuery, CustomService $customService, ActionLogService $actionLogService, UserService $userService)
    {
        $this->conn                 = config('custom_config.database.dts');
        $this->conn_user            = config('custom_config.database.users');
        $this->customRepository     = $customRepository;
        $this->customService        = $customService;
        $this->actionLogService     = $actionLogService;
        $this->userService          = $userService;
        $this->dtsQuery             = $dtsQuery;
        $this->documents_table      = 'documents';
        $this->history_table        = 'history';
        $this->outgoing_table       = 'outgoing_documents';
        $this->user_table           = 'users';
    }

    public function get_my_documents()
    {
        $items = array();
        $rows = $this->dtsQuery->get_my_documents();
        $i = 1;
        foreach ($rows as  $key) {

            $delete_button = $this->customRepository->q_get_where($this->conn, array('t_number' => $key->tracking_number), $this->history_table)->count() > 1 ? true : false;
            $status = $this->customService->check_status($key->doc_status);
            $origin = $key->origin == NULL ? '-' : $key->origin;
            $items[] = array(
                'number'            => $i++,
                'tracking_number'   => $key->tracking_number,
                'document_name'     => $key->document_name,
                'type_name'         => $key->type_name,
                'created'           => date('M d Y - h:i a', strtotime($key->d_created)),
                'a'                 => $delete_button,
                'document_id'       => $key->document_id,
                'is'                => $status,
                'doc_type'          => $key->doc_type,
                'description'       => $key->document_description,
                'destination_type'  => $key->destination_type,
                'doc_status'        => $key->doc_status,
                'name'              => $key->name,
                'document_type_name' => $key->type_name,
                'encoded_by'        => $this->userService->user_full_name($key),
                'origin'            => $origin,
                'origin_id'         => $key->origin_id,
                'data'              => $key->document_name.','.
                                       $key->tracking_number.','.
                                       $key->type_name.','.
                                       date('M d Y - h:i a', strtotime($key->d_created)).','.
                                       $this->userService->user_full_name($key).','.
                                       $key->destination_type.','.
                                       $origin.','.
                                       $key->document_description.','.
                                       $key->document_id
                                       

            );
        }

        return $items;
    }

    //ADD DOCUMENT PROCESS

    public function  add_document_process($request, $user_type)
    {

        $items = array(

            'tracking_number'   => $request->input('tracking_number'),
            'document_name'     => trim($request->input('document_name')),
            'u_id'              => base64_decode($request->input('user_id')),
            'offi_id'           => $request->input('office_id'),
            'doc_type'          => $request->input('document_type'),
            'document_description' => trim($request->input('description')),
            'created'           => Carbon::now()->format('Y-m-d H:i:s'),
            'doc_status'        => 'pending',
            'destination_type'  => $request->input('type'),
            'origin'            => $request->input('origin'),
        );



        $count = $this->customRepository->q_get_where($this->conn, array('tracking_number' => $items['tracking_number']), $this->documents_table)->count();
        if ($count == 0) {
            $add = DB::connection($this->conn)->table('documents')->insertGetId($items);
            if ($add) {
                $row = $this->customRepository->q_get_where($this->conn, array('document_id' => $add), $this->documents_table)->first();
                $items1 = array(
                    't_number'              => $row->tracking_number,
                    'user1'                 => $row->u_id,
                    'office1'               => $row->offi_id,
                    'user2'                 => $row->u_id,
                    'office2'               => $row->offi_id,
                    'status'                => 'received',
                    'received_status'       => '1',
                    'received_date'         => Carbon::now()->format('Y-m-d H:i:s'),
                    'release_status'        => NULL,
                    'to_receiver'           => 'no',
                    'release_date'          => NULL,
                );
                $add1 = $this->customRepository->insert_item($this->conn, $this->history_table, $items1);
                if ($add1) {
                    $this->actionLogService->dts_add_action('Added Document No. ' . $row->tracking_number, 'user',  $row->document_id);
                    $data = array('id' => $row->document_id, 'message' => 'Added Successfully', 'response' => true);
                } else {

                    $data = array('message' => 'Something Wrong', 'response' => false);
                }
            } else {

                $data = array('message' => 'Something Wrong', 'response' => false);
            }
        } else {
            $data = array('message' => 'Tracking Number is Existing', 'response' => false);
        }

        return $data;
    }

    //RECEIVED PROCESS
    public function received_process($history_id, $tracking_number, $user_type)
    {

        $to_update = array(

            'status'            => 'received',
            'received_status'   => 1,
            'received_date'     => Carbon::now()->format('Y-m-d H:i:s'),
        );

        $r = $this->document_data(array('tracking_number' => $tracking_number));

        if ($r->doc_status != 'cancelled') {

            $update_receive = $this->customRepository->update_item($this->conn, $this->history_table, array('history_id' => $history_id), $to_update);
            if ($update_receive) {
                $this->actionLogService->dts_add_action('Received Document No. ' . $tracking_number, $user_type, $r->document_id);
                $data = array('message' => 'Received Succesfully', 'id' => $history_id, 'tracking_number' => $tracking_number, 'response' => true);
            } else {
                $data = array('message' => 'Something Wrong', 'response' => false);
            }
        } else {
            $data = array('message' => 'This Document is cancelled', 'response' => false);
        }
        return $data;
    }

    //FORWARD PROCESS

    public function forward_process($remarks, $forward, $user_id, $history_id, $tracking_number, $user_type)
    {

        $forward_to         = $forward == 'fr' ?  $this->userService->get_receiver()->user_id : $forward;
        $user_row           = $this->userService->user_data($user_id);
        $forward_user_row   = $this->userService->user_data($forward_to);
        $r                  = $this->document_data(array('tracking_number' => $tracking_number));

        if ($r->doc_status != 'cancelled') {

            $update_release = $this->customRepository->update_item($this->conn, $this->history_table, array('history_id' => $history_id, 'received_status' => 1), array('release_status' => 1));

            if ($update_release) {


                $info = array(
                    't_number'          => $tracking_number,
                    'user1'             => $user_id,
                    'office1'           => $user_row->off_id,
                    'user2'             => $forward_to,
                    'office2'           => $forward_user_row->off_id,
                    'status'            => 'torec',
                    'received_status'   => NULL,
                    'received_date'     => NULL,
                    'release_status'    => NULL,
                    'to_receiver'       => $forward == 'fr' ? 'yes' : 'no',
                    'release_date'      => Carbon::now()->format('Y-m-d H:i:s'),
                    'remarks'           => $remarks

                );


                $add1 = $this->customRepository->insert_item($this->conn, $this->history_table, $info);

                if ($add1) {
                    $this->actionLogService->dts_add_action(
                        'Forwarded Document No. ' . $tracking_number . ' to ' . $this->userService->user_full_name($forward_user_row),
                        $user_type,
                        $r->document_id
                    );
                    $data = array('message' => 'Forwarded Successfully', 'response' => true);
                } else {

                    $data = array('message' => 'Something Wrong', 'response' => false);
                }
            } else {

                $data = array('message' => 'Something Wrong', 'response' => false);
            }
        } else {
            $data = array('message' => 'This Document is cancelled', 'response' => false);
        }

        return $data;
    }

    //RECIEVED ERROR PROCESS
    public function received_error_process($history_id, $tracking_number)
    {

        $items  = array(
            'status'            => 'torec',
            'received_status'   => NULL,
            'received_date'     => NULL
        );

        $r = $this->document_data(array('tracking_number' => $tracking_number));
        if ($r->doc_status != 'cancelled') {

            $update_receive = $this->customRepository->update_item($this->conn, $this->history_table, array('history_id' => $history_id), $items);
            if ($update_receive) {
                $this->actionLogService->dts_add_action($action = 'Received Error Document No. '.$tracking_number,$user_type='user',$_id = $r->document_id);
                $data = array('message' => 'Success', 'id' => $history_id, 'tracking_number' => $tracking_number, 'response' => true);
            } else {
                $data = array('message' => 'Something Wrong', 'response' => false);
            }
        } else {
            $data = array('message' => 'This Document is cancelled', 'response' => false);
        }

        return $data;
    }

    //OUTGOING PROCESS
    public function outgoing_documents_process($note, $office, $history_id, $tracking_number)
    {
        $where              = array('tracking_number' => $tracking_number);
        $r                  = $this->document_data($where);
        if ($r->doc_status != 'cancelled') {
            $info = array(
                'doc_status' => 'outgoing',
            );
            $add_items = array(
                'doc_id'        => $r->document_id,
                'user_Id'       => session('user_id'),
                'off_id'        => $office,
                'remarks'       => $note,
                'status'        => 'pending',
                'outgoing_date' => Carbon::now()->format('Y-m-d H:i:s'),
            );
           
            
        
            $add_outgoing = $this->customRepository->insert_item($this->conn,$this->outgoing_table, $add_items);
            $update_outgoing = $this->customRepository->update_item($this->conn,$this->documents_table, $where, $info);
            $this->actionLogService->dts_add_action('Outgoing Document No. ' . $r->tracking_number,'user', $_id = $r->document_id);
            $data = array('message' => 'Updated Succesfully', 'response' => true);
        } else {
            $data = array('message' => 'This Document is cancelled', 'response' => false);
        }

        return $data;
    }

   

    public function get_document_data($tn)
    {

        $row =  $this->dtsQuery->get_document_data($tn);
        $data = array(
            'document_name'         => $row->document_name,
            'tracking_number'       => $row->tracking_number,
            'encoded_by'            => $this->userService->user_full_name($row),
            'office'                => $row->office,
            'document_type'         => $row->type_name,
            'type_id'               => $row->type_id,
            'description'           => $row->document_description,
            'qr'                    => env('APP_URL') . '/storage/app/img/qr-code/' . $row->tracking_number . '.png',
            'status'                => $this->customService->check_status($row->doc_status),
            'destination_type'      => $row->destination_type
        );
        return $data;
    }

    public function get_document_history($tn){

        $history                    = $this->dtsQuery->get_document_history($tn);
        $data                       = [];

        foreach ($history->get() as $value => $row) {

            $where1                 = array('user_id' => $row->user1);
            $user1                  = $this->dtsQuery->history_user_data($where1);

            $where2                 = array('user_id' => $row->user2);
            $user2                  = $this->dtsQuery->history_user_data($where2);



            $date1                  = new DateTime($row->received_date);
            $date2                  = $row->release_date == NULL ? new DateTime($row->received_date) : new DateTime($row->release_date);
            $interval               = $date1->diff($date2);



            $min_ext                = $interval->i > 1 ? 'minutes' : 'minute';
            $hour_ext               = $interval->h > 1 ? 'hours' : 'hour';
            $days_ext               = $interval->d > 1 ? 'days' : 'day';
            $month_ext              = $interval->m > 1 ? 'months' : 'month';


            $display_month          = $interval->m == 0 ? ' ' : $interval->m . ' ' . $month_ext . ', ';
            $display_day            = $interval->d == 0 ? ' ' : $interval->d . ' ' . $days_ext . ', ';
            $display_hour           = $interval->h == 0 ? ' ' : $interval->h . ' ' . $hour_ext . ', ';
            $display_min            = $interval->i == 0 ? ' ' : $interval->i . ' ' . $min_ext;

            $user__2                = $user2[0]->is_receiver == 'yes' ? 'final' : $this->userService->user_full_name($user2[0]);


            $data[] = array(

                'user1'                 => $row->release_date != NULL ? $this->userService->user_full_name($user1[0]) : ' - ',
                'office1'               => $user1[0]->office,
                'user2'                 => $row->user2 != 0 ?  $user__2 : ' - ',
                'office2'               => $row->user2 != 0 ? $user2[0]->office : ' - ',
                'tracking_number'       => $row->t_number,
                'date_released'         => $row->release_date != NULL ? date('M d Y', strtotime($row->release_date)) . ' - ' . date('h:i a', strtotime($row->release_date)) : ' - ',
                'date_received'         => $row->received_date != NULL ? date('M d Y', strtotime($row->received_date)) . ' - ' . date('h:i a', strtotime($row->received_date)) : ' - ',
                'duration'              => $row->received_date != NULL ? $display_month . ' ' . $display_day . ' ' . $display_hour . ' ' . $display_min : ' - ',
                'remarks'               => empty($row->remarks) ? 'no remarks' : $row->remarks,
                'final_action_taken'    => $row->action_name
            );

        }

        return $data;
    }


    public function document_data($where)
    {
        $item =  $this->customRepository->q_get_where($this->conn, $where, $this->documents_table)->first();
        return $item;
    }
}
