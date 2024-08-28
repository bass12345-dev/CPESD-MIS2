<?php

namespace App\Repositories\pmas\user;

use Illuminate\Support\Facades\DB;

class UserPmasQuery
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

    public function QueryUserTransactionPerMonthYear($month, $year, $status)
    {
        $row = DB::connection($this->conn)->table('transactions')
            ->where('created_by', session('user_id'))
            ->where('transaction_status', $status)
            ->whereMonth('date_and_time_filed', '=', $month)
            ->whereYear('date_and_time_filed', '=', $year)
            ->count();
        return $row;

    }


    //Pending
    public function QueryUserPendingTransactions()
    {

        $row = DB::table($this->pmas_db_name . '.transactions as transactions')
            ->leftJoin($this->users_db_name . '.users', 'users.user_id', '=', 'transactions.created_by')
            ->leftJoin($this->pmas_db_name . '.responsible_section', 'responsible_section.responsible_section_id', '=', 'transactions.responsible_section_id')
            ->leftJoin($this->pmas_db_name . '.type_of_activities', 'type_of_activities.type_of_activity_id', '=', 'transactions.type_of_activity_id')
            ->leftJoin($this->pmas_db_name . '.responsibility_center', 'responsibility_center.responsibility_center_id', '=', 'transactions.responsibility_center_id')
            ->leftJoin($this->pmas_db_name . '.cso', 'cso.cso_id', '=', 'transactions.cso_Id')
            ->where('transactions.transaction_status', 'pending')
            ->where('transactions.created_by', session('user_id'))
            ->orderBy('transactions.number', 'desc')
            ->get();
        return $row;

    }

    //Limit

    public function QueryTransactionsLimit($limit)
    {

        $row = DB::table($this->pmas_db_name . '.transactions as transactions')
            ->leftJoin($this->users_db_name . '.users', 'users.user_id', '=', 'transactions.created_by')
            ->leftJoin($this->pmas_db_name . '.responsible_section', 'responsible_section.responsible_section_id', '=', 'transactions.responsible_section_id')
            ->leftJoin($this->pmas_db_name . '.type_of_activities', 'type_of_activities.type_of_activity_id', '=', 'transactions.type_of_activity_id')
            ->leftJoin($this->pmas_db_name . '.responsibility_center', 'responsibility_center.responsibility_center_id', '=', 'transactions.responsibility_center_id')
            ->leftJoin($this->pmas_db_name . '.cso', 'cso.cso_id', '=', 'transactions.cso_Id')
            ->orderBy('transactions.transaction_id', 'desc')
            ->limit($limit)
            ->get();
        return $row;

    }

    public function get_last_pmas_number_where($where){
        $row = DB::connection($this->conn)->table('transactions')
        ->whereYear('date_and_time_filed', '=', $where)
        ->orderBy('date_and_time_filed', 'desc');
    return $row;
    }


     //Completed
     public function QueryUserCompletedTransactions()
     {
 
         $row = DB::table($this->pmas_db_name . '.transactions as transactions')
             ->leftJoin($this->users_db_name . '.users', 'users.user_id', '=', 'transactions.created_by')
             ->leftJoin($this->pmas_db_name . '.responsible_section', 'responsible_section.responsible_section_id', '=', 'transactions.responsible_section_id')
             ->leftJoin($this->pmas_db_name . '.type_of_activities', 'type_of_activities.type_of_activity_id', '=', 'transactions.type_of_activity_id')
             ->leftJoin($this->pmas_db_name . '.responsibility_center', 'responsibility_center.responsibility_center_id', '=', 'transactions.responsibility_center_id')
             ->leftJoin($this->pmas_db_name . '.cso', 'cso.cso_id', '=', 'transactions.cso_Id')
             ->where('transactions.transaction_status', 'completed')
             ->where('transactions.created_by', session('user_id'))
             ->orderBy('transactions.number', 'desc')
             ->get();
         return $row;
 
     }

     //Transaction Data

     public function QueryTransactionData($id){

        $row = DB::table($this->pmas_db_name . '.transactions as transactions')
             ->leftJoin($this->users_db_name . '.users', 'users.user_id', '=', 'transactions.created_by')
             ->leftJoin($this->pmas_db_name . '.responsible_section', 'responsible_section.responsible_section_id', '=', 'transactions.responsible_section_id')
             ->leftJoin($this->pmas_db_name . '.type_of_activities', 'type_of_activities.type_of_activity_id', '=', 'transactions.type_of_activity_id')
             ->leftJoin($this->pmas_db_name . '.responsibility_center', 'responsibility_center.responsibility_center_id', '=', 'transactions.responsibility_center_id')
             ->leftJoin($this->pmas_db_name . '.cso', 'cso.cso_id', '=', 'transactions.cso_Id')
             ->where('transactions.transaction_id', $id)
             ->first();
        return $row;

     }
 
}
