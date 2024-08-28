<?php

namespace App\Services\dts\user;

use App\Repositories\CustomRepository;
use App\Repositories\dts\DtsQuery;
use Carbon\Carbon;

class DashboardService
{
    
    protected $conn;
    protected $conn_user;
    protected $customRepository;
    protected $documents_table;
    protected $history_table;
    protected $outgoing_table;
    protected $user_table;
    protected $dtsQuery;

    public function __construct(CustomRepository $customRepository,DtsQuery $dtsQuery ){
        $this->conn                 = config('custom_config.database.dts');
        $this->conn_user            = config('custom_config.database.users');
        $this->customRepository     = $customRepository;
        $this->dtsQuery             = $dtsQuery;
        $this->documents_table      = 'documents';
        $this->history_table        = 'history';
        $this->outgoing_table       = 'outgoing_documents';
        $this->user_table           = 'users';
        
    }


    public function user_dashboard_display(){

        $id = session('user_id');
        $date_now = Carbon::now()->format('Y-m-d');
        $received = $this->customRepository->q_get_where($this->conn,array('user2' => $id,'received_status' => 1,'status' => 'received','release_status' => NULL,'to_receiver'=> 'no'),$this->history_table)->count();
        $outgoing = $this->customRepository->q_get_where($this->conn,array('status' => 'pending','user_id'=> $id),$this->outgoing_table)->count();

        $data = array(

                'count_documents'   => $this->customRepository->q_get_where($this->conn,array('u_id' => $id),$this->documents_table)->count(),
                'incoming'          => $this->customRepository->q_get_where($this->conn,array('user2' => $id,'received_status' => NULL,'status' => 'torec','release_status' => NULL,'to_receiver'=> 'no'),$this->history_table)->count(),
                'received'          =>  $received - $outgoing,
                'forwarded'         => $this->customRepository->q_get_where($this->conn,array('user1' => $id,'received_status' => NULL,'status' => 'torec','release_status' => NULL),$this->history_table)->count(),
                'pending'           => $this->customRepository->q_get_where($this->conn,array('doc_status' => 'pending','u_id'=> $id),$this->documents_table)->count(),
                'completed'         => $this->customRepository->q_get_where($this->conn,array('doc_status' => 'completed','u_id'=> $id),$this->documents_table)->count(),
                'cancelled'         => $this->customRepository->q_get_where($this->conn,array('doc_status' => 'cancelled','u_id'=> $id),$this->documents_table)->count(),
                'encoded_outgoing'  => $this->customRepository->q_get_where($this->conn,array('doc_status' => 'outgoing','u_id'=> $id),$this->documents_table)->count(),
                'outgoing'          => $outgoing,
                'added_today'       => $this->dtsQuery->added_document_date_now($date_now),
               
        );

        return $data;

    }


    public function get_forwarded_documents(){
        //get users
        $users = $this->customRepository->q_get_where($this->conn_user,array('user_status'=>'active'),$this->user_table)->get();
        //store results
        $result = array();
        foreach($users as $row){
            $query_history =  $this->dtsQuery->count_forwarded_documents($row->user_id);
            if($query_history->count() > 0){
                array_push($result,$row->first_name.' - '.$query_history->count().' Document/s');
            }
            $query_history1 =  $this->dtsQuery->count_forwarded_documents_final($row->user_id);
            if($query_history1->count() > 0){
                array_push($result,'Final Receiver'.' - '.$query_history1->count().' Document/s');
            }
        }
        return $result;
    }
    


    



    
}