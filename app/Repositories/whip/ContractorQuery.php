<?php

namespace App\Repositories\whip;

use Illuminate\Support\Facades\DB;

class ContractorQuery
{
    protected $conn;
    protected $default_city;
    public function __construct()
    {
        $this->conn = config('custom_config.database.lls_whip');
        $this->default_city = config('custom_config.default_city');
    }
    public function q_search($conn, $search)
    {
        $rows = DB::connection($conn)->table('contractors as contractors')
            ->select(
                //Employee
                'contractors.contractor_id as contractor_id',
                'contractors.contractor_name as contractor_name',

            )
            ->where('contractor_name', 'LIKE', "%" . $search . "%")
            ->orderBy('contractor_name', 'asc')->get();
        return $rows;
    }


    public function QueryContractorOngoingAndCompleted()
    {

        $rows = DB::connection($this->conn)->table('contractors as contractors')
            ->leftJoin('projects', 'projects.contractor_id', '=', 'contractors.contractor_id')
            ->select(
                //Employee
                'contractors.contractor_name as contractor_name',
                'contractors.contractor_id as contractor_id',
                DB::raw('COUNT(IF(projects.project_status = "ongoing", 1, NULL)) as project_count_ongoing'),
                DB::raw('COUNT(IF(projects.project_status = "completed", 1, NULL)) as project_count_completed'),
            )
            ->groupBy('contractors.contractor_id')
            ->groupBy('contractors.contractor_name')
            ->orderBy('contractor_name', 'asc')->get();
        return $rows;

    }

    //Analytics
    public function QueryContractorInsideOutside(){

        $rows = DB::connection($this->conn)->table('contractors as contractors')
          ->select(
            DB::raw('COUNT(IF(contractors.city != "'.$this->default_city.'", 1, NULL)) as outside'),
            DB::raw('COUNT(IF(contractors.city = "'.$this->default_city.'", 1, NULL)) as inside'),
          )
          ->first();
        return $rows;
    }

    public function QueryWorkersInsideOutside(){

        $rows = DB::connection($this->conn)->table('project_employee as project_employee')
        ->leftJoin('employees', 'employees.employee_id', '=', 'project_employee.employee_id')
        //   ->select(
            
        //     DB::raw('COUNT(IF(employees.city != "'.$this->default_city.'", 1, NULL)) as outside'),
        //     DB::raw('COUNT(IF(employees.city = "'.$this->default_city.'", 1, NULL)) as inside'),
        //   )
          
          ->groupBy('project_employee.employee_id')
          ->get();
        return $rows;
    }







}