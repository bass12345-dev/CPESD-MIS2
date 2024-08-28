<?php

namespace App\Repositories\dts;

use Illuminate\Support\Facades\DB;

class ReceiverDtsQuery
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

  public function get_receiver_incoming_documents()
  {
    $row = DB::table($this->dts_table_name . '.history as history')
      ->leftJoin($this->dts_table_name . '.documents as documents', 'documents.tracking_number', '=', 'history.t_number')
      ->leftJoin($this->users_table_name . '.users as users', 'users.user_id', '=', 'history.user1')
      ->leftJoin($this->dts_table_name . '.document_types as document_types', 'document_types.type_id', '=', 'documents.doc_type')
      ->select(
        'documents.tracking_number as tracking_number',
        'documents.document_name as document_name',
        'documents.document_id as document_id',
        'documents.note as note',
        'users.user_type as user_type',
        'document_types.type_name as type_name',
        'history.release_date as release_date',
        'history.history_id as history_id',
        'history.remarks as remarks',
        'users.first_name as first_name',
        'users.middle_name as middle_name',
        'users.last_name as last_name',
        'users.extension as extension',
        DB::Raw("CONCAT(users.first_name, ' ', users.middle_name , ' ', users.last_name,' ',users.extension) as name")
      )
      ->where('user2', session('user_id'))
      ->where('received_status', NULL)
      ->where('status', 'torec')
      ->where('to_receiver', 'yes')
      ->where('release_status', NULL)
      ->orderBy('received_date', 'desc')->get();

    return $row;
  }


  public function search($search)
  {
    $rows = DB::table($this->dts_table_name.'.documents as documents')
        ->leftJoin($this->dts_table_name.'.document_types as document_types', 'document_types.type_id', '=', 'documents.doc_type')
        ->leftJoin($this->users_table_name.'.users as users', 'users.user_id', '=', 'documents.u_id')
      
        ->select(    //Documents
                    'documents.created as created', 
                    'documents.doc_status as doc_status',  
                    'documents.tracking_number as tracking_number', 
                    'documents.document_name as   document_name', 
                    'documents.document_id as document_id', 
                    'documents.doc_status as doc_status',
                    'documents.document_description as document_description',
                    'documents.u_id as u_id',
                    'documents.note as note',
                    //Document Types
                    'document_types.type_name',  
                    //User
                    'users.first_name as first_name', 
                    'users.middle_name as middle_name', 
                    'users.last_name as last_name', 
                    'users.extension as extension', 
                    'document_types.type_name as type_name',
                    //Histoty 
                    // 'history.remarks as remarks',
                    // 'history.history_id as history_id',
                    DB::Raw("CONCAT(users.first_name, ' ', users.middle_name , ' ', users.last_name,' ',users.extension) as name"))
        
        ->where(DB::raw("concat(documents.tracking_number, ' ', documents.document_name)"), 'LIKE', "%" . $search . "%")
        ->orderBy('documents.document_id', 'desc')->get();

        return $rows;
  }



}
