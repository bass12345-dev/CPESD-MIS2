<?php

namespace App\Repositories\sysm;

use Illuminate\Support\Facades\DB;

class SystemQuery
{


  //Login History

  public static function get_logged_in_history($conn)
  {
    $row =  DB::connection($conn)->table('logged_in_history')
      ->leftJoin('users', 'users.user_id', '=', 'logged_in_history.user_id')
      ->select(   //history

        'logged_in_history.logged_in_date as logged_in_date',
        //User
        'users.first_name as first_name',
        'users.middle_name as middle_name',
        'users.last_name as last_name',
        'users.extension as extension',
      )
      ->where('logged_in_history.web_type', 'cpesd-mis')
      ->orderBy('logged_in_history.logged_in_date', 'desc')
      ->get();
    return $row;
  }

  public static function get_logged_in_history_by_month($conn,$month,$year)
  {
    $row = DB::connection($conn)->table('logged_in_history')
      ->leftJoin('users', 'users.user_id', '=', 'logged_in_history.user_id')
      ->select(   //history

        'logged_in_history.logged_in_date as logged_in_date',
        //User
        'users.first_name as first_name',
        'users.middle_name as middle_name',
        'users.last_name as last_name',
        'users.extension as extension',
      )
      ->where('logged_in_history.web_type', 'cpesd-mis')
      ->whereMonth('logged_in_history.logged_in_date', '=', $month)
      ->whereYear('logged_in_history.logged_in_date', '=', $year)
      ->orderBy('logged_in_history.logged_in_date', 'desc')
      ->get();
    return $row;
  }



    
}
