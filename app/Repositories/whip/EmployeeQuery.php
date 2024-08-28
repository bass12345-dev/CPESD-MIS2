<?php

namespace App\Repositories\whip;

use Illuminate\Support\Facades\DB;

class EmployeeQuery
{

  protected $conn;
  protected $default_city;
  public function __construct(){
    $this->conn                 = config('custom_config.database.lls_whip');
    $this->default_city         = config('custom_config.default_city');
  }
  public function get_project_employee($conn, $id)
  {

    $rows = DB::connection($conn)->table('contractor_employee as contractor_employee')
      ->leftJoin('employees', 'employees.employee_id', '=', 'contractor_employee.employee_id')
      ->leftJoin('positions', 'positions.position_id', '=', 'contractor_employee.position_id')
      ->leftJoin('employment_status', 'employment_status.employ_stat_id', '=', 'contractor_employee.status_of_employment_id')
      ->select(
        'contractor_employee.contractor_employee_id as contractor_employee_id',
        //User
        'employees.first_name as first_name',
        'employees.middle_name as middle_name',
        'employees.last_name as last_name',
        'employees.extension as extension',
        'employees.province as province',
        'employees.city as city',
        'employees.barangay as barangay',
        'employees.street as street',
        'employees.gender as gender',
        //Position
        'positions.position_id as position_id',
        'positions.position as position',
        //Status
        'employment_status.employ_stat_id as employ_stat_id',
        'employment_status.status as status',
        //Nature of Employment
        'contractor_employee.employee_id as employee_id',
        'contractor_employee.nature_of_employment as nature_of_employment',
        'contractor_employee.start_date as start_date',
        'contractor_employee.end_date as end_date',
        'contractor_employee.level_of_employment as level_of_employment'
      )
      ->where('contractor_employee.project_id', $id)
      ->orderBy('employees.first_name', 'asc')
      ->get();

    return $rows;

  }


  //Nature of Employment

  public function nature_inside($id, $project_id)
  {
    $rows = DB::connection($this->conn)->table('project_employee as project_employee')
    ->leftJoin('employees', 'employees.employee_id', '=', 'project_employee.employee_id')
      ->select(

        //Employee
        'project_employee.nature_of_employment as nature_of_employment',
        DB::raw('COUNT(project_employee.nature_of_employment) as count_nature'),
      )
      ->where('employees.city', $this->default_city)
      ->where('project_employee.project_monitoring_id', $id)
      ->where('project_employee.project_id', $project_id)
      ->groupBy('project_employee.nature_of_employment')
      ->get();
    return $rows;
  }

  public function nature_outside($id, $project_id)
  {
    $rows = DB::connection($this->conn)->table('project_employee as project_employee')
    ->leftJoin('employees', 'employees.employee_id', '=', 'project_employee.employee_id')
      ->select(

        //Employee
        'project_employee.nature_of_employment as nature_of_employment',
        DB::raw('COUNT(project_employee.nature_of_employment) as count_nature'),
      )
      ->where('employees.city', '!=',$this->default_city)
      ->where('project_employee.project_monitoring_id', $id)
      ->where('project_employee.project_id', $project_id)
      ->groupBy('project_employee.nature_of_employment')
      ->get();
    return $rows;
  }

  public function get_unskilled_and_skilled($id,$project_id){

    $rows = DB::connection($this->conn)->table('project_employee as project_employee')
    ->leftJoin('employees', 'employees.employee_id', '=', 'project_employee.employee_id')
      ->select(
        //Employee
        'project_employee.nature_of_employment as nature_of_employment',
        DB::raw('COUNT(project_employee.nature_of_employment) as count_nature'),
      )
      ->where('project_employee.project_monitoring_id', $id)
      ->where('project_employee.project_id', $project_id)
      ->groupBy('project_employee.nature_of_employment')
      ->get();
    return $rows;

  }


  public function within_project($id, $project_id,$barangay)
  {
    $rows = DB::connection($this->conn)->table('project_employee as project_employee')
    ->leftJoin('employees', 'employees.employee_id', '=', 'project_employee.employee_id')
      ->select(

        //Employee
        'project_employee.nature_of_employment as nature_of_employment',
        DB::raw('COUNT(project_employee.nature_of_employment) as count_nature'),
      )
      ->where('employees.barangay',$barangay)
      ->where('project_employee.project_monitoring_id', $id)
      ->where('project_employee.project_id', $project_id)
      ->groupBy('project_employee.nature_of_employment')
      ->get();
    return $rows;
  }

  public function location_status_project($id, $project_id,$location_status)
  {
    $rows = DB::connection($this->conn)->table('project_employee as project_employee')
    ->leftJoin('employees', 'employees.employee_id', '=', 'project_employee.employee_id')
      ->select(

        //Employee
        'project_employee.nature_of_employment as nature_of_employment',
        DB::raw('COUNT(project_employee.nature_of_employment) as count_nature'),
      )
      ->where('project_employee.location_status',$location_status)
      ->where('employees.city',$this->default_city)
      ->where('project_employee.project_monitoring_id', $id)
      ->where('project_employee.project_id', $project_id)
      ->groupBy('project_employee.nature_of_employment')
      ->get();
    return $rows;
  }




}