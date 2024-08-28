<?php

namespace App\Repositories\cso;

use Illuminate\Support\Facades\DB;

class CSOQuery
{
    protected $conn;
    protected $pmas_db_name;

    public function __construct()
    {

        $this->conn = config('custom_config.database.pmas');
        $this->pmas_db_name = env('DB_DATABASE_PMAS');
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
 


    

    
}
