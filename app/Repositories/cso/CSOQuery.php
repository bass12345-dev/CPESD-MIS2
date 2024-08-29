<?php

namespace App\Repositories\cso;

use Illuminate\Support\Facades\DB;

class CSOQuery
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

    public function count_cso_activities($year,$activity,$cso_id){
    

        $row = DB::connection($this->conn)->table('transactions')
        ->where('type_of_activity_id', $activity)
        ->where('cso_Id', $cso_id)
        ->where('type_of_activity_id', $activity)
        ->whereYear('date_and_time_filed', '=', $year)
        ->count();
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
                //User
                'users.first_name as first_name',
                'users.middle_name as middle_name',
                'users.last_name as last_name',
                'users.extension as extension',
                'users.user_type as user_type',
              )
            ->where('activity_logs.type', 'cso')
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
            //User
            'users.first_name as first_name',
            'users.middle_name as middle_name',
            'users.last_name as last_name',
            'users.extension as extension',
            'users.user_type as user_type',
          )
        ->where('activity_logs.type', 'cso')
        ->whereMonth('activity_logs.activity_log_created', '=', $month)
        ->whereYear('activity_logs.activity_log_created', '=', $year)
        ->orderBy('activity_logs.activity_log_created', 'desc')
        ->get();
    return $row;
    }
 


    

    
}
