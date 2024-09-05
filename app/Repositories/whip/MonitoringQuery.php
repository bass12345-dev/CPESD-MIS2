<?php

namespace App\Repositories\whip;

use Illuminate\Support\Facades\DB;

class MonitoringQuery
{
  protected $conn;
  protected $default_city;
  protected $users_table_name;
  protected $lls_whip_table_name;
  public function __construct()
  {
    $this->conn = config('custom_config.database.lls_whip');
    $this->default_city = config('custom_config.default_city');
    $this->lls_whip_table_name = env('DB_DATABASE_LLS');
    $this->users_table_name = env('DB_DATABASE');
  }


  //Pending Monitoring Information

  //User
  public function get_user_pending_monitoring()
  {


    $rows = DB::table($this->lls_whip_table_name . '.project_monitoring as project_monitoring')
      ->leftJoin($this->lls_whip_table_name . '.projects', 'projects.project_id', '=', 'project_monitoring.project_id')
      ->leftJoin($this->lls_whip_table_name . '.contractors', 'contractors.contractor_id', '=', 'projects.contractor_id')
      ->leftJoin($this->users_table_name . '.users', 'users.user_id', '=', 'project_monitoring.added_by')
      ->select(
        //Contractors
        'contractors.contractor_id as contractor_id',
        'contractors.contractor_name as contractor_name',
        'contractors.status as contractor_status',

        //Project Monitoring
        'project_monitoring.date_of_monitoring as date_of_monitoring',
        'project_monitoring.specific_activity as specific_activity',
        'project_monitoring.monitoring_status as monitoring_status',
        'project_monitoring.project_monitoring_id as project_monitoring_id',
        'project_monitoring.whip_code as whip_code',

        //Projects
        'projects.project_id as project_id',
        'projects.project_title as project_title',
        'projects.street as street',
        'projects.barangay as barangay',
        'projects.project_cost as project_cost',
        'projects.project_status as project_status',
        'projects.date_started as date_started',
        //User
        'users.user_id as user_id',
        'users.user_type as user_type',
        'users.first_name as first_name',
        'users.middle_name as middle_name',
        'users.last_name as last_name',
        'users.extension as extension',

      )
      ->where('contractors.status', 'active')
      ->where('project_monitoring.monitoring_status', 'pending')
      ->where('project_monitoring.added_by', session('user_id'))
      ->orderBy('project_monitoring_id', 'desc')
      ->get();

    return $rows;
  }

  public function QueryMyApprovedMonitoring()
  {

    $rows = DB::connection($this->conn)->table('project_monitoring as project_monitoring')
      ->leftJoin('projects', 'projects.project_id', '=', 'project_monitoring.project_id')
      ->leftJoin('contractors', 'contractors.contractor_id', '=', 'projects.contractor_id')
      ->leftJoin($this->users_table_name . '.users', 'users.user_id', '=', 'project_monitoring.added_by')
      ->select(
        //Contractors
        'contractors.contractor_id as contractor_id',
        'contractors.contractor_name as contractor_name',
        'contractors.status as contractor_status',

        //Project Monitoring
        'project_monitoring.date_of_monitoring as date_of_monitoring',
        'project_monitoring.specific_activity as specific_activity',
        'project_monitoring.monitoring_status as monitoring_status',
        'project_monitoring.project_monitoring_id as project_monitoring_id',
        'project_monitoring.whip_code as whip_code',

        //Projects
        'projects.project_id as project_id',
        'projects.project_title as project_title',
        'projects.street as street',
        'projects.barangay as barangay',
        'projects.project_cost as project_cost',
        'projects.project_status as project_status',
        'projects.date_started as date_started',

        //User
        'users.user_id as user_id',
        'users.user_type as user_type',
        'users.first_name as first_name',
        'users.middle_name as middle_name',
        'users.last_name as last_name',
        'users.extension as extension',

      )
      ->where('contractors.status', 'active')
      ->where('project_monitoring.monitoring_status', 'approved')
      ->where('project_monitoring.added_by', session('user_id'))
      ->orderBy('project_monitoring_id', 'desc')
      ->get();

    return $rows;
  }

  public function QueryMyApprovedMonitoringByMonth($month, $year)
  {

    $rows = DB::connection($this->conn)->table('project_monitoring as project_monitoring')
      ->leftJoin('projects', 'projects.project_id', '=', 'project_monitoring.project_id')
      ->leftJoin('contractors', 'contractors.contractor_id', '=', 'projects.contractor_id')
      ->leftJoin($this->users_table_name . '.users', 'users.user_id', '=', 'project_monitoring.added_by')
      ->select(
        //Contractors
        'contractors.contractor_id as contractor_id',
        'contractors.contractor_name as contractor_name',
        'contractors.status as contractor_status',

        //Project Monitoring
        'project_monitoring.date_of_monitoring as date_of_monitoring',
        'project_monitoring.specific_activity as specific_activity',
        'project_monitoring.monitoring_status as monitoring_status',
        'project_monitoring.project_monitoring_id as project_monitoring_id',
        'project_monitoring.whip_code as whip_code',

        //Projects
        'projects.project_id as project_id',
        'projects.project_title as project_title',
        'projects.street as street',
        'projects.barangay as barangay',
        'projects.project_cost as project_cost',
        'projects.project_status as project_status',
        'projects.date_started as date_started',

        //User
        'users.user_id as user_id',
        'users.user_type as user_type',
        'users.first_name as first_name',
        'users.middle_name as middle_name',
        'users.last_name as last_name',
        'users.extension as extension',

      )
      ->where('contractors.status', 'active')
      ->where('project_monitoring.monitoring_status', 'approved')
      ->where('project_monitoring.added_by', session('user_id'))
      ->whereMonth('project_monitoring.approved_date', '=', $month)
      ->whereYear('project_monitoring.approved_date', '=', $year)
      ->orderBy('project_monitoring_id', 'desc')
      ->get();

    return $rows;
  }

  //admin
  public function get_admin_pending_monitoring()
  {


    $rows = DB::connection($this->conn)->table('project_monitoring as project_monitoring')
      ->leftJoin('projects', 'projects.project_id', '=', 'project_monitoring.project_id')
      ->leftJoin('contractors', 'contractors.contractor_id', '=', 'projects.contractor_id')
      ->leftJoin($this->users_table_name . '.users', 'users.user_id', '=', 'project_monitoring.added_by')
      ->select(
        //Contractors
        'contractors.contractor_id as contractor_id',
        'contractors.contractor_name as contractor_name',
        'contractors.status as contractor_status',

        //Project Monitoring
        'project_monitoring.date_of_monitoring as date_of_monitoring',
        'project_monitoring.specific_activity as specific_activity',
        'project_monitoring.monitoring_status as monitoring_status',
        'project_monitoring.project_monitoring_id as project_monitoring_id',
        'project_monitoring.whip_code as whip_code',


        //Projects
        'projects.project_id as project_id',
        'projects.project_title as project_title',
        'projects.street as street',
        'projects.barangay as barangay',
        'projects.project_cost as project_cost',
        'projects.project_status as project_status',
        'projects.date_started as date_started',
        //User
        'users.user_id as user_id',
        'users.user_type as user_type',
        'users.first_name as first_name',
        'users.middle_name as middle_name',
        'users.last_name as last_name',
        'users.extension as extension',

      )
      ->where('contractors.status', 'active')
      ->where('project_monitoring.monitoring_status', 'pending')
      ->orderBy('project_monitoring_id', 'desc')
      ->get();

    return $rows;
  }

  //Approved Monitoring Projects

  public function QueryAllApprovedMonitoring()
  {

    $rows = DB::connection($this->conn)->table('project_monitoring as project_monitoring')
      ->leftJoin('projects', 'projects.project_id', '=', 'project_monitoring.project_id')
      ->leftJoin('contractors', 'contractors.contractor_id', '=', 'projects.contractor_id')
      ->leftJoin($this->users_table_name . '.users', 'users.user_id', '=', 'project_monitoring.added_by')
      ->select(
        //Contractors
        'contractors.contractor_id as contractor_id',
        'contractors.contractor_name as contractor_name',
        'contractors.status as contractor_status',

        //Project Monitoring
        'project_monitoring.date_of_monitoring as date_of_monitoring',
        'project_monitoring.specific_activity as specific_activity',
        'project_monitoring.monitoring_status as monitoring_status',
        'project_monitoring.project_monitoring_id as project_monitoring_id',
        'project_monitoring.whip_code as whip_code',

        //Projects
        'projects.project_id as project_id',
        'projects.project_title as project_title',
        'projects.street as street',
        'projects.barangay as barangay',
        'projects.project_cost as project_cost',
        'projects.project_status as project_status',
        'projects.date_started as date_started',

        //User
        'users.user_id as user_id',
        'users.user_type as user_type',
        'users.first_name as first_name',
        'users.middle_name as middle_name',
        'users.last_name as last_name',
        'users.extension as extension',

      )
      ->where('contractors.status', 'active')
      ->where('project_monitoring.monitoring_status', 'approved')
      ->orderBy('project_monitoring_id', 'desc')
      ->get();

    return $rows;
  }

  public function QueryApprovedMonitoringByMonth($month, $year)
  {

    $rows = DB::connection($this->conn)->table('project_monitoring as project_monitoring')
      ->leftJoin('projects', 'projects.project_id', '=', 'project_monitoring.project_id')
      ->leftJoin('contractors', 'contractors.contractor_id', '=', 'projects.contractor_id')
      ->leftJoin($this->users_table_name . '.users', 'users.user_id', '=', 'project_monitoring.added_by')
      ->select(
        //Contractors
        'contractors.contractor_id as contractor_id',
        'contractors.contractor_name as contractor_name',
        'contractors.status as contractor_status',

        //Project Monitoring
        'project_monitoring.date_of_monitoring as date_of_monitoring',
        'project_monitoring.specific_activity as specific_activity',
        'project_monitoring.monitoring_status as monitoring_status',
        'project_monitoring.project_monitoring_id as project_monitoring_id',
        'project_monitoring.whip_code as whip_code',

        //Projects
        'projects.project_id as project_id',
        'projects.project_title as project_title',
        'projects.street as street',
        'projects.barangay as barangay',
        'projects.project_cost as project_cost',
        'projects.project_status as project_status',
        'projects.date_started as date_started',

        //User
        'users.user_id as user_id',
        'users.user_type as user_type',
        'users.first_name as first_name',
        'users.middle_name as middle_name',
        'users.last_name as last_name',
        'users.extension as extension',

      )
      ->where('contractors.status', 'active')
      ->where('project_monitoring.monitoring_status', 'approved')
      ->whereMonth('project_monitoring.approved_date', '=', $month)
      ->whereYear('project_monitoring.approved_date', '=', $year)
      ->orderBy('project_monitoring_id', 'desc')
      ->get();

    return $rows;
  }

  public function QueryRemarks($id)
  {

    $rows = DB::table($this->lls_whip_table_name . '.remarks as remarks')
      ->leftJoin($this->users_table_name . '.users', 'users.user_id', '=', 'remarks.user_id')
      ->select(
        //Remarks
        'remarks.remarks as remarks',
        'remarks.user_id as user_id',
        //User
        'users.user_type as user_type',
        'users.first_name as first_name',
        'users.middle_name as middle_name',
        'users.last_name as last_name',
        'users.extension as extension',

      )
      ->where('remarks.project_monitoring_id', $id)
      ->orderBy('created_on', 'asc')
      ->get();

    return $rows;
  }

  public function get_whip_monitoring_where_and_year_and_month($where, $year, $m)
  {

    return DB::connection($this->conn)->table('project_monitoring')->where($where)->whereMonth('created_on', '=', $m)->whereYear('created_on', '=', $year);
  }


  public function get_whip_code($where)
  {
    $row = DB::connection($this->conn)->table('project_monitoring')
      ->whereYear('created_on', '=', $where)
      ->orderBy('created_on', 'desc');
    return $row;
  }
}
