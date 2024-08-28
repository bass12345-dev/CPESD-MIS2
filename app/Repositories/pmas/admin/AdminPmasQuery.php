<?php

namespace App\Repositories\pmas\admin;

use Illuminate\Support\Facades\DB;

class AdminPmasQuery
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

    public function QueryAdminTransactionPerMonthYear($month, $year, $status)
    {
        $row = DB::connection($this->conn)->table('transactions')
            ->where('transaction_status', $status)
            ->whereMonth('date_and_time_filed', '=', $month)
            ->whereYear('date_and_time_filed', '=', $year)
            ->count();
        return $row;

    }


    //Pending
    public function QueryPendingTransactions()
    {

        $row = DB::table($this->pmas_db_name . '.transactions as transactions')
            ->leftJoin($this->users_db_name . '.users', 'users.user_id', '=', 'transactions.created_by')
            ->leftJoin($this->pmas_db_name . '.responsible_section', 'responsible_section.responsible_section_id', '=', 'transactions.responsible_section_id')
            ->leftJoin($this->pmas_db_name . '.type_of_activities', 'type_of_activities.type_of_activity_id', '=', 'transactions.type_of_activity_id')
            ->leftJoin($this->pmas_db_name . '.responsibility_center', 'responsibility_center.responsibility_center_id', '=', 'transactions.responsibility_center_id')
            ->leftJoin($this->pmas_db_name . '.cso', 'cso.cso_id', '=', 'transactions.cso_Id')
            ->where('transactions.transaction_status', 'pending')
            ->orderBy('transactions.number', 'desc')
            ->get();
        return $row;

    }

    public function QueryPendingTransactionsDateFilter($filter_data){
        $row = DB::table($this->pmas_db_name . '.transactions as transactions')
        ->leftJoin($this->users_db_name . '.users', 'users.user_id', '=', 'transactions.created_by')
        ->leftJoin($this->pmas_db_name . '.responsible_section', 'responsible_section.responsible_section_id', '=', 'transactions.responsible_section_id')
        ->leftJoin($this->pmas_db_name . '.type_of_activities', 'type_of_activities.type_of_activity_id', '=', 'transactions.type_of_activity_id')
        ->leftJoin($this->pmas_db_name . '.responsibility_center', 'responsibility_center.responsibility_center_id', '=', 'transactions.responsibility_center_id')
        ->leftJoin($this->pmas_db_name . '.cso', 'cso.cso_id', '=', 'transactions.cso_Id')
        ->whereRaw("DATE_FORMAT(transactions.date_and_time_filed,'%Y-%m-%d') >= '".$filter_data['start_date']."' ")
        ->whereRaw("DATE_FORMAT(transactions.date_and_time_filed,'%Y-%m-%d') <= '".$filter_data['end_date']."'")
        ->where('transactions.transaction_status', 'pending')
        ->orderBy('transactions.number', 'desc')
        ->get();
    return $row;


    
    }

   

    //Report

    public function QueryCompletedTransactionDateFilterWhere($filter_data){
        $row = DB::table($this->pmas_db_name . '.transactions as transactions')
        ->leftJoin($this->users_db_name . '.users', 'users.user_id', '=', 'transactions.created_by')
        ->leftJoin($this->pmas_db_name . '.responsible_section', 'responsible_section.responsible_section_id', '=', 'transactions.responsible_section_id')
        ->leftJoin($this->pmas_db_name . '.type_of_activities', 'type_of_activities.type_of_activity_id', '=', 'transactions.type_of_activity_id')
        ->leftJoin($this->pmas_db_name . '.responsibility_center', 'responsibility_center.responsibility_center_id', '=', 'transactions.responsibility_center_id')
        ->leftJoin($this->pmas_db_name . '.cso', 'cso.cso_id', '=', 'transactions.cso_Id')
        ->whereRaw("DATE_FORMAT(transactions.date_and_time_filed,'%Y-%m-%d') >= '".$filter_data['start_date']."' ")
        ->whereRaw("DATE_FORMAT(transactions.date_and_time_filed,'%Y-%m-%d') <= '".$filter_data['end_date']."'")
        ->where('transactions.type_of_activity_id', $filter_data['type_of_activity'])
        ->where('transactions.transaction_status', 'completed')
        ->orderBy('transactions.number', 'desc')
        ->get();
        return $row;
    }


    public function QueryCompletedTransactionDateFilterWhereCSO($filter_data){
        $row = DB::table($this->pmas_db_name . '.transactions as transactions')
        ->leftJoin($this->users_db_name . '.users', 'users.user_id', '=', 'transactions.created_by')
        ->leftJoin($this->pmas_db_name . '.responsible_section', 'responsible_section.responsible_section_id', '=', 'transactions.responsible_section_id')
        ->leftJoin($this->pmas_db_name . '.type_of_activities', 'type_of_activities.type_of_activity_id', '=', 'transactions.type_of_activity_id')
        ->leftJoin($this->pmas_db_name . '.responsibility_center', 'responsibility_center.responsibility_center_id', '=', 'transactions.responsibility_center_id')
        ->leftJoin($this->pmas_db_name . '.cso', 'cso.cso_id', '=', 'transactions.cso_Id')
        ->whereRaw("DATE_FORMAT(transactions.date_and_time_filed,'%Y-%m-%d') >= '".$filter_data['start_date']."' ")
        ->whereRaw("DATE_FORMAT(transactions.date_and_time_filed,'%Y-%m-%d') <= '".$filter_data['end_date']."'")
        ->where('transactions.type_of_activity_id', $filter_data['type_of_activity'])
        ->where('transactions.cso_Id', $filter_data['cso_Id'])
        ->where('transactions.transaction_status', 'completed')
        ->orderBy('transactions.number', 'desc')
        ->get();
        return $row;
    }



    public function QueryCompletedTransactionDateFilter($filter_data){
        $row = DB::table($this->pmas_db_name . '.transactions as transactions')
        ->leftJoin($this->users_db_name . '.users', 'users.user_id', '=', 'transactions.created_by')
        ->leftJoin($this->pmas_db_name . '.responsible_section', 'responsible_section.responsible_section_id', '=', 'transactions.responsible_section_id')
        ->leftJoin($this->pmas_db_name . '.type_of_activities', 'type_of_activities.type_of_activity_id', '=', 'transactions.type_of_activity_id')
        ->leftJoin($this->pmas_db_name . '.responsibility_center', 'responsibility_center.responsibility_center_id', '=', 'transactions.responsibility_center_id')
        ->leftJoin($this->pmas_db_name . '.cso', 'cso.cso_id', '=', 'transactions.cso_Id')
        ->whereRaw("DATE_FORMAT(transactions.date_and_time_filed,'%Y-%m-%d') >= '".$filter_data['start_date']."' ")
        ->whereRaw("DATE_FORMAT(transactions.date_and_time_filed,'%Y-%m-%d') <= '".$filter_data['end_date']."'")
        ->where('transactions.transaction_status', 'completed')
        ->orderBy('transactions.number', 'desc')
        ->get();
        return $row;
    }








    //Calc
    public function QueryProjectMonitoringWhereSUM($column,$where){
        
        $row = DB::connection($this->conn)->table('project_monitoring')
        ->where($where)
        ->sum($column);
        return $row;
        
    }


   
 
}
