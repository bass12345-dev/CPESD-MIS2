<?php

namespace App\Repositories\dts;

use Illuminate\Support\Facades\DB;

class AdminDtsQuery
{

  protected $conn_dts;
  protected $dts_table_name;
  protected $conn_user;
  protected $users_table_name;

  public function __construct()
  {
    $this->conn_dts = config('custom_config.database.dts');
    $this->dts_table_name = env('DB_DATABASE_DTS');
    $this->conn_user = config('custom_config.database.users');
    $this->users_table_name = env('DB_DATABASE');
  }

  //Admin Dashboard
  public function completed_document_date_now($now)
  {

    $rows = DB::table($this->dts_table_name . '.documents as documents')
      ->leftJoin($this->dts_table_name . '.document_types as document_types', 'document_types.type_id', '=', 'documents.doc_type')
      ->leftJoin($this->users_table_name . '.users as users', 'users.user_id', '=', 'documents.u_id')
      
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
      ->whereDate('documents.completed_on', '=', $now)
      ->where('documents.doc_status', 'completed')
      ->orderBy('documents.document_id', 'desc')->get();

    return $rows;
  }

  public function get_all_documents_with_limit_completed($limit)
  {
    $rows = DB::table($this->dts_table_name . '.documents as documents')
      ->leftJoin($this->dts_table_name . '.document_types as document_types', 'document_types.type_id', '=', 'documents.doc_type')
      ->leftJoin($this->users_table_name . '.users as users', 'users.user_id', '=', 'documents.u_id')
      
      ->select(   //Documents
        'documents.created as created',
        'documents.tracking_number as tracking_number',
        'documents.document_name as document_name',
        'documents.document_id as document_id',
        'documents.destination_type as destination_type',
        
        //Document Types
        'document_types.type_name as type_name',

       
        //User
        'users.first_name as first_name',
        'users.middle_name as middle_name',
        'users.last_name as last_name',
        'users.extension as extension',
        DB::Raw("CONCAT(users.first_name, ' ', users.middle_name , ' ', users.last_name,' ',users.extension) as name")
      )
      ->where('documents.doc_status', 'completed')
      ->orderBy('documents.tracking_number', 'desc')->limit($limit)->get();
    return $rows;
  }


  public function count_unreceived_documents_admin($user_id)
  {
    return DB::connection($this->conn_dts)->table('history as history')
      ->leftJoin('documents as documents', 'documents.tracking_number', '=', 'history.t_number')
      ->where('user2', $user_id)
      ->where('doc_status', '!=', 'cancelled')
      ->where('received_status', NULL)
      ->where('status', 'torec')
      ->where('to_receiver', 'no')
      ->where('release_status', NULL)
      ->orderBy('tracking_number', 'desc');
  }

  public function count_received_documents_admin($user_id)
  {
    return DB::connection($this->conn_dts)->table('history as history')
      ->leftJoin('documents as documents', 'documents.tracking_number', '=', 'history.t_number')
      ->where('user2', $user_id)
      ->where('received_status', 1)
      ->where('release_status', NULL)
      ->where('status', 'received')
      ->where('doc_status', '!=', 'cancelled')
      ->where('doc_status', '!=', 'outgoing')
      // ->where('documents.destination_type', 'complex')
      ->where('to_receiver', 'no')
      ->orderBy('tracking_number', 'desc');
  }

  //Analytics
  public function get_documents_where_and_year($table, $where, $col, $year)
  {

    return DB::connection($this->conn_dts)->table($table)->where($where)->whereYear($col, '=', $year);
  }


  public function get_documents_where_and_year_and_month($table, $where, $col, $year, $m)
  {

    return DB::connection($this->conn_dts)->table($table)->where($where)->whereMonth($col, '=', $m)->whereYear($col, '=', $year);
  }

  //All Documents
  public function QueryAllDocuments()
  {
    $rows = DB::connection($this->conn_dts)->table($this->dts_table_name . '.documents as documents')
      ->leftJoin($this->dts_table_name . '.document_types as document_types', 'document_types.type_id', '=', 'documents.doc_type')
      ->leftJoin($this->users_table_name . '.users as users', 'users.user_id', '=', 'documents.u_id')
      ->leftJoin($this->dts_table_name.'.offices as offices', 'offices.office_id', '=', 'documents.origin')
      ->select(    //Documents
        'documents.created as created',
        'documents.doc_status as doc_status',
        'documents.tracking_number as tracking_number',
        'documents.document_name as   document_name',
        'documents.document_id as document_id',
        'documents.doc_status as doc_status',
        'documents.u_id as u_id',
        'documents.origin as origin_id',
        'documents.document_description as document_description',
        'documents.destination_type as destination_type',
        //Document Types
        'document_types.type_name',

        'offices.office as origin',
        //User
        'users.first_name as first_name',
        'users.middle_name as middle_name',
        'users.last_name as last_name',
        'users.extension as extension',
        DB::Raw("CONCAT(users.first_name, ' ', users.middle_name , ' ', users.last_name,' ',users.extension) as name")
      )
      ->orderBy('documents.document_id', 'desc')->get();

    return $rows;
  }

  public function QueryDocumentsByMonth($month, $year)
  {

    $rows = DB::connection($this->conn_dts)->table($this->dts_table_name . '.documents as documents')
      ->leftJoin($this->dts_table_name . '.document_types as document_types', 'document_types.type_id', '=', 'documents.doc_type')
      ->leftJoin($this->users_table_name . '.users as users', 'users.user_id', '=', 'documents.u_id')
      ->leftJoin($this->dts_table_name.'.offices as offices', 'offices.office_id', '=', 'documents.origin')


      ->select(    //Documents
        'documents.created as created',
        'documents.doc_status as doc_status',
        'documents.tracking_number as tracking_number',
        'documents.document_name as   document_name',
        'documents.document_id as document_id',
        'documents.doc_status as doc_status',
        'documents.u_id as u_id',
        'documents.document_description as document_description',
        'documents.destination_type as destination_type',
        //Document Types
        'document_types.type_name',
        'documents.origin as origin_id',

        'offices.office as origin',
        //User
        'users.first_name as first_name',
        'users.middle_name as middle_name',
        'users.last_name as last_name',
        'users.extension as extension',
        DB::Raw("CONCAT(users.first_name, ' ', users.middle_name , ' ', users.last_name,' ',users.extension) as name")
      )
      ->whereMonth('documents.created', '=', $month)
      ->whereYear('documents.created', '=', $year)
      ->orderBy('documents.document_id', 'desc')->get();

    return $rows;
  }

  //Action Logs

  public function QueryAllActionLogs()
  {
    $row =  DB::connection($this->conn_dts)->table($this->dts_table_name.'.action_logs')
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
      ->orderBy('action_logs.action_datetime', 'desc')
      ->get();
    return $row;
  }

  public function QueryActionLogsPerMonth($month, $year)
  {
    $row =  DB::connection($this->conn_dts)->table($this->dts_table_name.'.action_logs')
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
      ->orderBy('action_logs.action_datetime', 'desc')
      ->get();
    return $row;
  }


  public function QueryLoggedInHistory(){
    $row = DB::connection($this->conn_dts)->table($this->dts_table_name.'.logged_in_history')
      ->leftJoin($this->users_table_name.'.users', 'users.user_id', '=', 'logged_in_history.user_id')
      ->select(   //history

        'logged_in_history.logged_in_date as logged_in_date',
        //User
        'users.first_name as first_name',
        'users.middle_name as middle_name',
        'users.last_name as last_name',
        'users.extension as extension',
      )
      ->where('logged_in_history.web_type', 'dts')
      ->orderBy('logged_in_history.logged_in_date', 'desc')
      ->get();
    return $row;

  }

  public function QueryLoggedInHistoryByMonth($month, $year){
    $row =  DB::connection($this->conn_dts)->table($this->dts_table_name.'.logged_in_history')
      ->leftJoin($this->users_table_name.'.users', 'users.user_id', '=', 'logged_in_history.user_id')
      ->select(   //history

        'logged_in_history.logged_in_date as logged_in_date',
        //User
        'users.first_name as first_name',
        'users.middle_name as middle_name',
        'users.last_name as last_name',
        'users.extension as extension',
      )
      ->where('logged_in_history.web_type', 'dts')
      ->whereMonth('logged_in_history.logged_in_date', '=', $month)
      ->whereYear('logged_in_history.logged_in_date', '=', $year)
      ->orderBy('logged_in_history.logged_in_date', 'desc')
      ->get();
    return $row;
  }
}
