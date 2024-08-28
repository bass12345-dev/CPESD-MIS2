<?php

namespace App\Services\dts\admin;

use App\Repositories\CustomRepository;
use App\Repositories\dts\AdminDtsQuery;
use App\Repositories\dts\DtsQuery;
use Carbon\Carbon;
use DateTime;
class DashboardService
{
    
    protected $conn;
    protected $conn_user;
    protected $customRepository;
    protected $adminDtsQuery;

    protected $documents_table;
    protected $history_table;
    protected $outgoing_table;
    protected $office_table;
    protected $user_table;
    protected $document_types_table;
    protected $final_actions_table;
    protected $logged_in_history;
    protected $dtsQuery;

    public function __construct(CustomRepository $customRepository,DtsQuery $dtsQuery, AdminDtsQuery $adminDtsQuery ){
        $this->conn                 = config('custom_config.database.dts');
        $this->conn_user            = config('custom_config.database.users');
        $this->customRepository     = $customRepository;
        $this->dtsQuery             = $dtsQuery;
        $this->adminDtsQuery        = $adminDtsQuery;
        $this->documents_table      = 'documents';
        $this->history_table        = 'history';
        $this->outgoing_table       = 'outgoing_documents';
        $this->office_table         = 'offices';
        $this->document_types_table = 'document_types';
        $this->final_actions_table  = 'final_actions';
        $this->user_table           = 'users';
        $this->logged_in_history    = 'logged_in_history';
    }


    public function count_menu_data()
    {
        $date_now = Carbon::now()->format('Y-m-d');
        $data = array(

            'count_documents'       => $this->customRepository->q_get($this->conn,$this->documents_table)->count(),
            'count_offices'         => $this->customRepository->q_get_where($this->conn,array('office_status' => 'active'),$this->office_table)->count(),
            'count_document_types'  => $this->customRepository->q_get($this->conn,$this->document_types_table)->count(),
            'count_users'           => $this->customRepository->q_get_where($this->conn_user,array('user_status'=>'active'),$this->user_table)->count(),
            'final_actions'         => $this->customRepository->q_get($this->conn,$this->final_actions_table)->count(),
            'pending'               => $this->customRepository->q_get_where($this->conn,array('doc_status' => 'pending'),$this->documents_table)->count(),
            'completed'             => $this->customRepository->q_get_where($this->conn,array('doc_status' => 'completed'),$this->documents_table)->count(),
            'cancelled'             => $this->customRepository->q_get_where($this->conn,array('doc_status' => 'cancelled'),$this->documents_table)->count(),
            'added_today'           => $this->dtsQuery->added_document_date_now($date_now),
            'completed_today'       => $this->adminDtsQuery->completed_document_date_now($date_now),
            'latest'                => $this->adminDtsQuery->get_all_documents_with_limit_completed('10'),
            'outgoing'              => $this->customRepository->q_get_where($this->conn,array('status' => 'pending'), $this->outgoing_table)->count(),
            'final_receiver'        => $this->customRepository->q_get_where($this->conn, array('received_status' => NULL, 'status' => 'torec', 'release_status' => NULL, 'to_receiver' => 'yes'), $this->history_table,)->count()

        );

        return $data;
    }


    function calculate_inactive_logged(){
        #get users
         $users = $this->customRepository->q_get_where($this->conn_user,array('user_status'=>'active'),$this->user_table)->get();
        #store results
        $result = array();
        foreach($users as $row){
            $query_history =  $this->customRepository->q_get_where_order($this->conn_user,$this->logged_in_history, array('user_id' => $row->user_id),'logged_in_history_id','desc');
            if($query_history->count() > 0){
                $get_history = $query_history->get()[0];
                $date_now_              = new DateTime(Carbon::now()->format('Y-m-d H:i:s'));
                $logged_in_date         = new DateTime($get_history->logged_in_date);
                #Difference Between Two Dayas
                $interval               = $date_now_->diff($logged_in_date);
                #Count Days
                $count_days = $interval->d;
                
                #count unreceived documents
                $count_unreceived = $this->adminDtsQuery->count_unreceived_documents_admin($row->user_id)->count();
                $count_received = $this->adminDtsQuery->count_received_documents_admin($row->user_id)->count();

                $name = $count_days  > 1 ?  
                array_push($result, '<span class="text-danger">'.$row->first_name.' is '.$count_days.' days Inactive'.'</span><br><span class="text-danger fw-bold">Incoming : '.$count_unreceived.' | Received : '.$count_received.'<span>' ):  
                array_push($result, '<span class="text-success">'.$row->first_name.' is an Active User'.'</span><br><span class="text-danger fw-bold">Incoming : '.$count_unreceived.' | Received : '.$count_received.'<span>' );
            }else {
                array_push($result, '<span class="text-danger">'.$row->first_name.' - walay open2x sa iyang account'.'</span>' );
            }

            
        }

        return $result;
    }


    //Analytics
    public function count_documents_by_types($year){
        
        $item_types         =  $this->customRepository->q_get($this->conn,$this->document_types_table)->get();
        $count_documents    = array();
        $label              = array();

        foreach ($item_types as $row) {
            $count          = $this->adminDtsQuery->get_documents_where_and_year($this->documents_table,array('doc_type' => $row->type_id),'created',$year)->count();
            array_push($count_documents, $count);
            array_push($label,$row->type_name);
        }

        $data['count_documents']    = $count_documents;
        $data['label']              = $label;

        return $data;
        
    }


    public function count_documents_per_month($year){

        $months           = array();
        $completed        = array();
        $pending          = array();
        $cancelled        = array();

        for ($m = 1; $m <= 12; $m++) {

            $completed_doc          =  $this->adminDtsQuery->get_documents_where_and_year_and_month($this->documents_table,array('doc_status' => 'completed'),'created',$year,$m)->count();
            $pending_doc            =  $this->adminDtsQuery->get_documents_where_and_year_and_month($this->documents_table,array('doc_status' => 'pending'),'created',$year,$m)->count();
            $cancelled_doc          =  $this->adminDtsQuery->get_documents_where_and_year_and_month($this->documents_table,array('doc_status' => 'cancelled'),'created',$year,$m)->count();
            $month                  =  date('M', mktime(0, 0, 0, $m, 1));
            array_push($months, $month);
            array_push($completed, $completed_doc);
            array_push($cancelled, $cancelled_doc);
            array_push($pending, $pending_doc);
        }
        $data['label']                      = $months;
        $data['data_pending']               = $pending;
        $data['data_completed']             = $completed;
        $data['data_cancelled']             = $cancelled;
       
        return $data;

        
    }

    



    
}