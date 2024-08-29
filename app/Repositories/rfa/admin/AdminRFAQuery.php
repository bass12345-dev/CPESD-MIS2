<?php

namespace App\Repositories\rfa\admin;

use Illuminate\Support\Facades\DB;

class AdminRFAQuery
{

    protected $conn;
    protected $pmas_db_name;
    protected $users_db_name;

    public function __construct()
    {

        $this->conn = config('custom_config.database.pmas');
        $this->pmas_db_name = env('DB_DATABASE_PMAS');
        $this->users_db_name = env('DB_DATABASE');
    }
    //Dashboard 
    public function QueryCountTransactionMonthYear($month,$year,$status){

        $row = DB::connection($this->conn)->table('rfa_transactions')
        ->where('rfa_status', $status)
        ->whereMonth('rfa_date_filed', '=', $month)
        ->whereYear('rfa_date_filed', '=', $year)
        ->count();
    return $row;

    }

    public function QueryGenderByMonthAndYear($month,$year,$gender){

        $row = DB::connection($this->conn)->table('rfa_clients')
        ->where('gender', $gender)
        ->whereMonth('rfa_client_created', '=', $month)
        ->whereYear('rfa_client_created', '=', $year)
        ->count();
    return $row;

    }

    public function QueryPendingRFALIMIT($limit) {


        $row = DB::table($this->pmas_db_name . '.rfa_transactions as rfa_transactions')
        ->leftJoin($this->pmas_db_name . '.type_of_request', 'type_of_request.type_of_request_id', '=', 'rfa_transactions.tor_id')
        ->leftJoin($this->pmas_db_name . '.rfa_clients', 'rfa_clients.rfa_client_id', '=', 'rfa_transactions.client_id')
        ->leftJoin($this->users_db_name . '.users', 'users.user_id', '=', 'rfa_transactions.rfa_created_by')
        ->select(
            //Contractors
            'rfa_transactions.rfa_date_filed as rfa_date_filed',
            'rfa_transactions.rfa_id as rfa_id',
            'rfa_transactions.rfa_date_filed as rfa_date_filed',
            'rfa_transactions.number as number',
            'rfa_transactions.reffered_to as reffered_to',
            'rfa_transactions.tor_id as tor_id',


            'rfa_clients.rfa_client_id as rfa_client_id',
            'rfa_clients.first_name as client_first_name',
            'rfa_clients.middle_name as client_middle_name',
            'rfa_clients.last_name as client_last_name',
            'rfa_clients.extension as client_extension',
            'rfa_clients.purok as client_purok',
            'rfa_clients.barangay as client_barangay',



            'type_of_request.type_of_request_name as type_of_request_name',
            'type_of_request.type_of_request_id as type_of_request_id',

            'rfa_transactions.type_of_transaction as type_of_transaction',

            'users.user_id as user_id',
            'users.first_name as first_name',
            'users.middle_name as middle_name',
            'users.last_name as last_name',
            'users.extension as extension',


        )
        ->where('rfa_transactions.rfa_status', 'pending')
        ->orderBy('rfa_transactions.rfa_date_filed', 'desc')
        ->limit($limit)
        ->get();
        return $row;

    }

    //PEnding

    public function QueryPendingRFA() {


        $row = DB::table($this->pmas_db_name . '.rfa_transactions as rfa_transactions')
        ->leftJoin($this->pmas_db_name . '.type_of_request as type_of_request', 'type_of_request.type_of_request_id', '=', 'rfa_transactions.tor_id')
        ->leftJoin($this->pmas_db_name . '.rfa_clients as rfa_clients', 'rfa_clients.rfa_client_id', '=', 'rfa_transactions.client_id')
        ->leftJoin($this->users_db_name . '.users as users', 'users.user_id', '=', 'rfa_transactions.rfa_created_by')
        ->leftJoin($this->users_db_name . '.users as referred', 'referred.user_id', '=', 'rfa_transactions.reffered_to')
        ->select(
            //Contractors
            'rfa_transactions.rfa_date_filed as rfa_date_filed',
            'rfa_transactions.rfa_id as rfa_id',
            'rfa_transactions.rfa_date_filed as rfa_date_filed',
            'rfa_transactions.number as number',
            'rfa_transactions.reffered_to as reffered_to',
            'rfa_transactions.tor_id as tor_id',
            'rfa_transactions.accomplished_status as accomplished_status',


            'rfa_clients.rfa_client_id as rfa_client_id',
            'rfa_clients.first_name as client_first_name',
            'rfa_clients.middle_name as client_middle_name',
            'rfa_clients.last_name as client_last_name',
            'rfa_clients.extension as client_extension',
            'rfa_clients.purok as client_purok',
            'rfa_clients.barangay as client_barangay',



            'type_of_request.type_of_request_name as type_of_request_name',
            'type_of_request.type_of_request_id as type_of_request_id',

            'rfa_transactions.type_of_transaction as type_of_transaction',

            'users.user_id as user_id',
            'users.first_name as first_name',
            'users.middle_name as middle_name',
            'users.last_name as last_name',
            'users.extension as extension',


            'referred.user_id as reffered_user_id',
            'referred.first_name as reffered_first_name',
            'referred.middle_name as reffered_middle_name',
            'referred.last_name as reffered_last_name',
            'referred.extension as reffered_extension',


        )
        ->where('rfa_transactions.rfa_status', 'pending')
        ->orderBy('rfa_transactions.rfa_date_filed', 'desc')
        ->get();
        return $row;

    }


    public function QueryRFATransactionDateFilter($filter_data){

        $row = DB::table($this->pmas_db_name . '.rfa_transactions as rfa_transactions')
        ->leftJoin($this->pmas_db_name . '.type_of_request as type_of_request', 'type_of_request.type_of_request_id', '=', 'rfa_transactions.tor_id')
        ->leftJoin($this->pmas_db_name . '.rfa_clients as rfa_clients', 'rfa_clients.rfa_client_id', '=', 'rfa_transactions.client_id')
        ->leftJoin($this->users_db_name . '.users as users', 'users.user_id', '=', 'rfa_transactions.rfa_created_by')
        ->leftJoin($this->users_db_name . '.users as referred', 'referred.user_id', '=', 'rfa_transactions.reffered_to')
        ->select(
            //Contractors
            'rfa_transactions.rfa_date_filed as rfa_date_filed',
            'rfa_transactions.rfa_id as rfa_id',
            'rfa_transactions.rfa_date_filed as rfa_date_filed',
            'rfa_transactions.number as number',
            'rfa_transactions.reffered_to as reffered_to',
            'rfa_transactions.tor_id as tor_id',
            'rfa_transactions.accomplished_status as accomplished_status',


            'rfa_clients.rfa_client_id as rfa_client_id',
            'rfa_clients.first_name as client_first_name',
            'rfa_clients.middle_name as client_middle_name',
            'rfa_clients.last_name as client_last_name',
            'rfa_clients.extension as client_extension',
            'rfa_clients.purok as client_purok',
            'rfa_clients.barangay as client_barangay',



            'type_of_request.type_of_request_name as type_of_request_name',
            'type_of_request.type_of_request_id as type_of_request_id',

            'rfa_transactions.type_of_transaction as type_of_transaction',

            'users.user_id as user_id',
            'users.first_name as first_name',
            'users.middle_name as middle_name',
            'users.last_name as last_name',
            'users.extension as extension',


            'referred.user_id as reffered_user_id',
            'referred.first_name as reffered_first_name',
            'referred.middle_name as reffered_middle_name',
            'referred.last_name as reffered_last_name',
            'referred.extension as reffered_extension',


        )
        ->where('rfa_transactions.rfa_status', 'completed')
        ->whereRaw("DATE_FORMAT(rfa_transactions.rfa_date_filed,'%Y-%m-%d') >= '".$filter_data['start_date']."' ")
        ->whereRaw("DATE_FORMAT(rfa_transactions.rfa_date_filed,'%Y-%m-%d') <= '".$filter_data['end_date']."'")
        ->orderBy('rfa_transactions.rfa_date_filed', 'desc')
        ->get();
        return $row;

    }


    public function QueryRFAData($id)
    {

        $row = DB::table($this->pmas_db_name . '.rfa_transactions as rfa_transactions')
            ->leftJoin($this->pmas_db_name . '.type_of_request', 'type_of_request.type_of_request_id', '=', 'rfa_transactions.tor_id')
            ->leftJoin($this->pmas_db_name . '.rfa_clients', 'rfa_clients.rfa_client_id', '=', 'rfa_transactions.client_id')
            ->leftJoin($this->users_db_name . '.users', 'users.user_id', '=', 'rfa_transactions.rfa_created_by')
            ->leftJoin($this->users_db_name . '.users as referred', 'referred.user_id', '=', 'rfa_transactions.reffered_to')
            ->select(
                //Contractors
                'rfa_transactions.rfa_date_filed as rfa_date_filed',
                'rfa_transactions.rfa_id as rfa_id',
                'rfa_transactions.rfa_date_filed as rfa_date_filed',
                'rfa_transactions.number as number',
                'rfa_transactions.reffered_to as reffered_to',
                'rfa_transactions.tor_id as tor_id',
                'rfa_transactions.accomplished_status as accomplished_status',
                'rfa_transactions.rfa_status as rfa_status',
                'rfa_transactions.approved_date as approved_date',
    
    
                'rfa_clients.rfa_client_id as rfa_client_id',
                'rfa_clients.first_name as client_first_name',
                'rfa_clients.middle_name as client_middle_name',
                'rfa_clients.last_name as client_last_name',
                'rfa_clients.extension as client_extension',
                'rfa_clients.purok as client_purok',
                'rfa_clients.barangay as client_barangay',
    
    
    
                'type_of_request.type_of_request_name as type_of_request_name',
                'type_of_request.type_of_request_id as type_of_request_id',
    
                'rfa_transactions.type_of_transaction as type_of_transaction',
    
                'users.user_id as user_id',
                'users.first_name as first_name',
                'users.middle_name as middle_name',
                'users.last_name as last_name',
                'users.extension as extension',
    
    
                'referred.user_id as reffered_user_id',
                'referred.first_name as reffered_first_name',
                'referred.middle_name as reffered_middle_name',
                'referred.last_name as reffered_last_name',
                'referred.extension as reffered_extension',
    
    
            )
            ->where('rfa_transactions.rfa_id', $id)
        
            ->orderBy('rfa_transactions.rfa_date_filed', 'desc')
            ->first();
        return $row;


    }




      //Actioon Logs

      public function QueryAllActionLogs()
      {
          $row = DB::table($this->pmas_db_name . '.activity_logs as activity_logs')
              ->leftJoin($this->users_db_name . '.users', 'users.user_id', '=', 'activity_logs.user_id')
              ->leftJoin($this->pmas_db_name . '.transactions', 'transactions.transaction_id', '=', 'activity_logs._id')
              ->select(   //history
      
                  'activity_logs.activity_log_created as activity_log_created',
                  'activity_logs.action as action',
                  'activity_logs._id as _id',
                  //User
                  'users.first_name as first_name',
                  'users.middle_name as middle_name',
                  'users.last_name as last_name',
                  'users.extension as extension',
                  'users.user_type as user_type',
                )
              ->where('activity_logs.type', 'rfa')
              ->orderBy('activity_logs.activity_log_created', 'desc')
              ->get();
          return $row;
      }
  
      public function QueryActionLogsPerMonth($month, $year) {
          $row = DB::table($this->pmas_db_name . '.activity_logs as activity_logs')
          ->leftJoin($this->users_db_name . '.users', 'users.user_id', '=', 'activity_logs.user_id')
          ->leftJoin($this->pmas_db_name . '.transactions', 'transactions.transaction_id', '=', 'activity_logs._id')
          ->select(   //history
  
              'activity_logs.activity_log_created as activity_log_created',
              'activity_logs.action as action',
              'activity_logs._id as _id',
              //User
              'users.first_name as first_name',
              'users.middle_name as middle_name',
              'users.last_name as last_name',
              'users.extension as extension',
              'users.user_type as user_type',
            )
          ->where('activity_logs.type', 'rfa')
          ->whereMonth('activity_logs.activity_log_created', '=', $month)
          ->whereYear('activity_logs.activity_log_created', '=', $year)
          ->orderBy('activity_logs.activity_log_created', 'desc')
          ->get();
      return $row;
      }


}
