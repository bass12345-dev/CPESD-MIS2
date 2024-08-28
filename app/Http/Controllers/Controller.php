<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
class Controller
{
    public function sample(){
        return DB::connection('mysql_LLS')->table('establishments')->get();
    }
    public function sample_user(){
        return DB::connection('mysql_users')->table('users')->get();
    }
}
