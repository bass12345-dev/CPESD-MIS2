<?php

namespace App\Repositories\dts;

use Illuminate\Support\Facades\DB;

class DtsQuery
{

  protected $conn_dts;
  protected $dts_table_name;
  protected $conn_user;
  protected $users_table_name;

  public function __construct(){
    $this->conn_dts             = config('custom_config.database.dts');
    $this->dts_table_name       = env('DB_DATABASE_DTS');
    $this->conn_user            = config('custom_config.database.users');
    $this->users_table_name     = env('DB_DATABASE');
    
  }

    //User Dashboard
    public function added_document_date_now($now)
    {

        $rows = DB::table($this->dts_table_name.'.documents as documents')
            ->leftjoin($this->users_table_name.'.users as users', 'users.user_id', '=', 'documents.u_id')
            ->leftJoin($this->dts_table_name.'.document_types as document_types', 'document_types.type_id', '=', 'documents.doc_type')
            ->select(   //Documents
                'documents.created as created',
                'documents.tracking_number as tracking_number',
                'documents.document_name as   document_name',
                'documents.document_id as document_id',
                'document_types.type_name as type_name',
                'documents.doc_status as doc_status',
                'documents.u_id as u_id',
                'documents.destination_type as destination_type',
                //User
                'users.first_name as first_name',
                'users.middle_name as middle_name',
                'users.last_name as last_name',
                'users.extension as extension',
                DB::Raw("CONCAT(users.first_name, ' ', users.middle_name , ' ', users.last_name,' ',users.extension) as name")
            )
            ->whereDate('documents.created', '=', $now)
            ->orderBy('documents.document_id', 'desc')->get();

        return $rows;


    }


    public function count_forwarded_documents($user_id)
    {
        $row = DB::connection($this->conn_dts)->table('history as history')
            ->leftJoin('documents as documents', 'documents.tracking_number', '=', 'history.t_number')
            ->where('user1', session('user_id'))
            ->where('user2', $user_id)
            ->where('doc_status', '!=', 'cancelled')
            ->where('received_status', NULL)
            ->where('status', 'torec')
            ->where('to_receiver', 'no')
            ->where('release_status', NULL)
            ->orderBy('tracking_number', 'desc');

        return $row;

    }

    public function count_forwarded_documents_final($user_id)
    {
        $row = DB::connection($this->conn_dts)->table('history as history')
            ->leftJoin('documents as documents', 'documents.tracking_number', '=', 'history.t_number')
            ->where('user1', session('user_id'))
            ->where('user2', $user_id)
            ->where('doc_status', '!=', 'cancelled')
            ->where('received_status', NULL)
            ->where('status', 'torec')
            ->where('to_receiver', 'yes')
            ->where('release_status', NULL)
            ->orderBy('tracking_number', 'desc');

        return $row;

    }


    // User My Documents
    public function get_my_documents()
    {

        $rows = DB::table($this->dts_table_name.'.documents as documents')
            ->leftjoin($this->users_table_name.'.users as users', 'users.user_id', '=', 'documents.u_id')
            ->leftJoin($this->dts_table_name.'.document_types as document_types', 'document_types.type_id', '=', 'documents.doc_type')
            ->leftJoin($this->dts_table_name.'.offices as offices', 'offices.office_id', '=', 'documents.origin')
            ->select(
                'documents.created as d_created',
                'documents.doc_status as doc_status',
                'documents.tracking_number as tracking_number',
                'documents.document_name as document_name',
                'documents.document_id as document_id',
                'documents.doc_type as doc_type',
                'documents.document_description as document_description',
                'documents.destination_type as destination_type',
                'documents.origin as origin_id',
                'document_types.type_name as type_name',
                'users.first_name as first_name',
                'users.middle_name as middle_name',
                'users.last_name as last_name',
                'users.extension as extension',

                'offices.office as origin',


                DB::Raw("CONCAT(users.first_name, ' ', users.middle_name , ' ', users.last_name,' ',users.extension) as name")
            )
            ->where('u_id', session('user_id'))
            ->orderBy('documents.document_id', 'desc')
            ->get();
        return $rows;
    }


    //Document Data
    public function get_document_data($tn){
        $row = DB::table($this->dts_table_name.'.documents')
        ->leftJoin($this->dts_table_name.'.document_types', 'document_types.type_id', '=', 'documents.doc_type')
        ->leftJoin($this->users_table_name.'.users', 'users.user_id', '=', 'documents.u_id')
        ->leftJoin($this->dts_table_name.'.offices', 'offices.office_id', '=', 'documents.origin')
        ->where('tracking_number', $tn)
        ->first();
        return $row;
    }

    //IncomingDocuments

    public function get_incoming_documents()
    {

        $rows = DB::table($this->dts_table_name.'.history as history')
            ->leftJoin($this->dts_table_name.'.documents as documents', 'documents.tracking_number', '=', 'history.t_number')
            ->leftJoin($this->users_table_name.'.users as users', 'users.user_id', '=', 'history.user1')
            ->leftJoin($this->dts_table_name.'.document_types as document_types', 'document_types.type_id', '=', 'documents.doc_type')
            ->select(   //Document
                'documents.tracking_number as tracking_number',
                'documents.document_name as document_name',
                'documents.doc_status as doc_status',
                'documents.document_id as document_id',
                //Document Type
                'document_types.type_name as type_name',
                //History
                'history.release_date as release_date',
                'history.history_id as history_id',
                'history.remarks as remarks',
                //User
                'users.user_type as user_type',
                'users.first_name as first_name',
                'users.middle_name as middle_name',
                'users.last_name as last_name',
                'users.extension as extension',
                DB::Raw("CONCAT(users.first_name, ' ', users.middle_name , ' ', users.last_name,' ',users.extension) as name")
            )
            ->where('user2', session('user_id'))
            ->where('doc_status', '!=', 'cancelled')
            ->where('received_status', NULL)
            ->where('status', 'torec')
            ->where('to_receiver', 'no')
            ->where('release_status', NULL)
            ->orderBy('tracking_number', 'desc')->get();

        return $rows;
    }

    //Received Documents
    public function get_received_documents()
    {

        $rows = DB::table($this->dts_table_name.'.history as history')
            ->leftJoin($this->dts_table_name.'.documents as documents', 'documents.tracking_number', '=', 'history.t_number')
            ->leftJoin($this->users_table_name.'.users as users', 'users.user_id', '=', 'history.user2')
            ->leftJoin($this->dts_table_name.'.document_types as document_types', 'document_types.type_id', '=', 'documents.doc_type')
            ->select(   //Document
                'documents.tracking_number as tracking_number',
                'documents.doc_status as doc_status',
                'documents.document_name as document_name',
                'documents.document_id as document_id',
                //Document Type
                'document_types.type_name as type_name',
                //User
                'users.user_type as user_type',
                //History
                'history.received_date as received_date',
                'history.history_id as history_id',
                'history.remarks as remarks'
            )
            ->where('user2', session('user_id'))
            ->where('received_status', 1)
            ->where('release_status', NULL)
            ->where('status', 'received')
            ->where('doc_status', '!=', 'cancelled')
            ->where('doc_status', '!=', 'outgoing')
            // ->where('documents.destination_type', 'complex')
            ->where('to_receiver', 'no')
            ->orderBy('tracking_number', 'desc')->get();

        return $rows;

    }


    //Forwarded Documents

    public function QueryForwardedDocuments()
    {
        $rows = DB::table($this->dts_table_name.'.history as history')
            ->leftJoin($this->dts_table_name.'.documents as documents', 'documents.tracking_number', '=', 'history.t_number')
            ->leftJoin($this->users_table_name.'.users as users', 'users.user_id', '=', 'history.user2')
            ->leftJoin($this->dts_table_name.'.document_types as document_types', 'document_types.type_id', '=', 'documents.doc_type')
            ->select(  //Document
                'documents.tracking_number as tracking_number',
                'documents.doc_status as doc_status',
                'documents.document_name as document_name',
                'documents.document_id as document_id',
                //Documen Type
                'document_types.type_name as type_name',
                //History
                'history.release_date as release_date',
                'history.history_id as history_id',
                'history.remarks as remarks',
                'history.to_receiver as final_receiver',
                //User
                'users.user_id as user_id',
                'users.user_type as user_type',
                'users.first_name as first_name',
                'users.middle_name as middle_name',
                'users.last_name as last_name',
                'users.extension as extension',
                DB::Raw("CONCAT(
                                        users.first_name, ' ', 
                                        users.middle_name , ' ', 
                                        users.last_name,' ',
                                        users.extension) as name")
            )
            ->where('user1', session('user_id'))
            ->where('doc_status', '!=', 'cancelled')
            ->where('received_status', NULL)
            ->where('status', 'torec')
            ->where('release_status', NULL)
            ->orderBy('tracking_number', 'desc')->get();

        return $rows;
    }

    //Outgoing Controller

    public function get_outgoing_documents()
    {
        $row = DB::table($this->dts_table_name.'.outgoing_documents as outgoing_documents')
            ->leftJoin($this->dts_table_name.'.documents as documents', 'documents.document_id', '=', 'outgoing_documents.doc_id')
            ->leftJoin($this->users_table_name.'.users as users', 'users.user_id', '=', 'outgoing_documents.user_id')
            ->leftJoin($this->dts_table_name.'.offices as offices', 'offices.office_id', '=', 'outgoing_documents.off_id')
            ->leftJoin($this->dts_table_name.'.document_types as document_types', 'document_types.type_id', '=', 'documents.doc_type')
            ->select(  //Document
                'documents.tracking_number as tracking_number',
                'documents.doc_status as doc_status',
                'documents.document_name as document_name',
                'documents.document_id as document_id',
                //Documen Type
                'document_types.type_name as type_name',
                //Outgoing
                'outgoing_documents.remarks as remarks',
                'outgoing_documents.outgoing_date as outgoing_date',
                'outgoing_documents.doc_id as doc_id',
                'outgoing_documents.outgoing_id as outgoing_id',
                //Office
                'offices.office as office',
                'offices.office_id as office_id',
                //User
                'users.user_id as user_id',
                'users.user_type as user_type',
                'users.first_name as first_name',
                'users.middle_name as middle_name',
                'users.last_name as last_name',
                'users.extension as extension',
            )
            ->where('outgoing_documents.user_id', session('user_id'))
            ->where('outgoing_documents.status', '=', 'pending')
            ->orderBy('documents.tracking_number', 'desc')
            ->get();


        return $row;
    }

    //User Action Logs
    public function get_user_actions_dts(){
        $row = DB::table($this->dts_table_name.'.action_logs')
        ->leftJoin($this->users_table_name.'.users', 'users.user_id', '=', 'action_logs.user_id')
        ->leftJoin($this->dts_table_name.'.documents', 'documents.document_id', '=', 'action_logs._id')
        ->select(   //history
            
            'action_logs.action_datetime as action_datetime', 
            'action_logs.action as action',
            'action_logs.user_type as user_type',
            'action_logs._id as _id',
            //Documents
            'documents.tracking_number as tracking_number',
            //User
            'users.first_name as first_name', 
            'users.middle_name as middle_name', 
            'users.last_name as last_name', 
            'users.extension as extension', 
          )
        ->where('action_logs.web_type','dts')
        ->where('action_logs.user_id',session('user_id'))
        ->orderBy('action_logs.action_datetime', 'desc')
        ->get();
        return $row;
    }

    // User Action Logs
    public function QueryActionLogs(){
        $row = DB::table($this->dts_table_name.'.action_logs')
        ->leftJoin($this->users_table_name.'.users', 'users.user_id', '=', 'action_logs.user_id')
        ->leftJoin($this->dts_table_name.'.documents', 'documents.document_id', '=', 'action_logs._id')
        ->select(   //history
  
          'action_logs.action_datetime as action_datetime',
          'action_logs.action as action',
          'action_logs.user_type as user_type',
          'action_logs._id as _id',
          //Documents
          'documents.tracking_number as tracking_number',
          //User
          'users.first_name as first_name',
          'users.middle_name as middle_name',
          'users.last_name as last_name',
          'users.extension as extension',
        )
        ->where('action_logs.web_type', 'dts')
        ->where('action_logs.user_id',session('user_id'))
        ->orderBy('action_logs.action_datetime', 'desc')
        ->get();
      return $row;

    }
    public function QueryActionLogsPerMonth($month, $year){
        $row = DB::table($this->dts_table_name.'.action_logs')
        ->leftJoin($this->users_table_name.'.users', 'users.user_id', '=', 'action_logs.user_id')
        ->leftJoin($this->dts_table_name.'.documents', 'documents.document_id', '=', 'action_logs._id')
        ->select(   //history
  
          'action_logs.action_datetime as action_datetime',
          'action_logs.action as action',
          'action_logs.user_type as user_type',
          'action_logs._id as _id',
          //Documents
          'documents.tracking_number as tracking_number',
          //User
          'users.first_name as first_name',
          'users.middle_name as middle_name',
          'users.last_name as last_name',
          'users.extension as extension',
        )
        ->where('action_logs.web_type', 'dts')
        ->whereMonth('action_logs.action_datetime', '=', $month)
        ->whereYear('action_logs.action_datetime', '=', $year)
        ->where('action_logs.user_id',session('user_id'))
        ->orderBy('action_logs.action_datetime', 'desc')
        ->get();
      return $row;
    }

    //Documents Limit 10

    public function get_all_documents_with_limit($limit)
    {


        $rows = DB::table($this->dts_table_name.'.documents as documents')
            ->leftjoin($this->users_table_name.'.users as users', 'users.user_id', '=', 'documents.u_id')
            ->leftJoin($this->dts_table_name.'.document_types as document_types', 'document_types.type_id', '=', 'documents.doc_type')
            ->leftJoin($this->dts_table_name.'.offices as offices', 'offices.office_id', '=', 'documents.origin')
            ->select(
                'documents.created as d_created',
                'documents.doc_status as doc_status',
                'documents.tracking_number as tracking_number',
                'documents.document_name as document_name',
                'documents.document_id as document_id',
                'documents.doc_type as doc_type',
                'documents.document_description as document_description',
                'documents.destination_type as destination_type',
                'documents.origin as origin_id',
                'document_types.type_name as type_name',
                'users.first_name as first_name',
                'users.middle_name as middle_name',
                'users.last_name as last_name',
                'users.extension as extension',

                'offices.office as origin',


                DB::Raw("CONCAT(users.first_name, ' ', users.middle_name , ' ', users.last_name,' ',users.extension) as name")
            )
            ->orderBy('documents.tracking_number', 'desc')->limit($limit)->get();

        return $rows;
    }



    //Search
    public function search($search)
    {
        $rows = DB::table($this->dts_table_name.'.documents as documents')
        ->leftJoin($this->dts_table_name.'.document_types as document_types', 'document_types.type_id', '=', 'documents.doc_type')
        ->leftJoin($this->users_table_name.'.users as users', 'users.user_id', '=', 'documents.u_id')
        // ->leftJoin($this->dts_table_name.'.history as history', 'history.t_number', '=', 'documents.tracking_number')
        ->select(    //Documents
                    'documents.created as created', 
                    'documents.doc_status as doc_status',  
                    'documents.tracking_number as tracking_number', 
                    'documents.document_name as   document_name', 
                    'documents.document_id as document_id', 
                    'documents.doc_status as doc_status',
                    'documents.document_description as document_description',
                    'documents.u_id as u_id',
                    //Document Types
                    'document_types.type_name',  
                    //User
                    'users.first_name as first_name', 
                    'users.middle_name as middle_name', 
                    'users.last_name as last_name', 
                    'users.extension as extension', 
                    
                    DB::Raw("CONCAT(users.first_name, ' ', users.middle_name , ' ', users.last_name,' ',users.extension) as name"))
        ->where(DB::raw("concat(documents.document_name, ' ', documents.tracking_number, ' ', documents.document_description)"), 'LIKE', "%" . $search . "%")
        ->orderBy('documents.document_id', 'desc')->get();

        return $rows;

    }


    public function get_document_history($tn){
        $row = DB::connection($this->conn_dts)->table('history')
        ->where('t_number',$tn)
        ->leftJoin('final_actions', 'final_actions.action_id', '=', 'history.final_action_taken')
        ->orderBy('history.history_id','asc');
        return $row;
    }

    public function  history_user_data($where){
        $row =  DB::table($this->users_table_name.'.users')
        ->leftJoin($this->dts_table_name.'.offices', 'offices.office_id', '=', 'users.off_id')
        ->where($where)
        ->get();
        return $row;
    }


    public function get_outgoing_history($tn){

        $row = DB::table($this->dts_table_name.'.outgoing_documents as outgoing_documents')
             ->leftJoin($this->dts_table_name.'.documents as documents', 'documents.document_id', '=', 'outgoing_documents.doc_id')
             ->leftJoin($this->users_table_name.'.users as users', 'users.user_id', '=', 'outgoing_documents.user_id')
             ->leftJoin($this->dts_table_name.'.offices as offices', 'offices.office_id', '=', 'outgoing_documents.off_id')
             ->leftJoin($this->dts_table_name.'.document_types as document_types', 'document_types.type_id', '=', 'documents.doc_type')
             ->select(  //Document
                        'documents.tracking_number as tracking_number',
                        'documents.doc_status as doc_status' ,
                        'documents.document_name as document_name',
                        'documents.document_id as document_id',
                        //Documen Type
                        'document_types.type_name as type_name',
                        //Outgoing
                        'outgoing_documents.remarks as remarks',
                        'outgoing_documents.outgoing_date as outgoing_date',
                        'outgoing_documents.outgoing_date_received as outgoing_date_received',
                        'outgoing_documents.doc_id as doc_id',
                        'outgoing_documents.outgoing_id as outgoing_id',
                        'outgoing_documents.status as status',
                        //Office
                        'offices.office as office',
                        //User
                        'users.user_id as user_id',
                        'users.user_type as user_type',
                        'users.first_name as first_name', 
                        'users.middle_name as middle_name', 
                        'users.last_name as last_name', 
                        'users.extension as extension',
             )
             ->where('documents.tracking_number', $tn)
             ->orderBy('outgoing_documents.outgoing_id', 'asc')
            ->get();

        return $row;
    }


}
