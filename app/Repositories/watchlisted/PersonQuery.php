<?php

namespace App\Repositories\watchlisted;

use Illuminate\Support\Facades\DB;

class PersonQuery
{
    protected $conn_dts;
    protected $dts_table_name;
    protected $conn_user;
    protected $users_table_name;

    public function __construct()
    {
        $this->conn_dts = config('custom_config.database.dts');
        $this->dts_table_name = env('DB_DATABASE_DTS');
        $this->conn_user = config('custom_config.database.users');
        $this->users_table_name = env('DB_DATABASE');
    }



    public function search($search)
    {
        $row = DB::connection($this->conn_dts)->table('persons')->select("person_id", "first_name", "last_name", "middle_name", "address", "email_address", "phone_number", "age", "extension", "status")->where(DB::raw("concat(first_name, ' ', last_name)"), 'LIKE', "%" . $search . "%")->get();
        return $row;
    }

    public function QueryPersonData($id)
    {

        return DB::table($this->dts_table_name . '.persons')
            ->leftJoin($this->users_table_name . '.users as users', 'users.user_id', '=', 'persons.added_by')
            ->select(
                'persons.person_id as person_id',
                'persons.first_name as first_name',
                'persons.middle_name as middle_name',
                'persons.last_name as last_name',
                'persons.extension as extension',

                'persons.phone_number as phone_number',
                'persons.email_address as email_address',
                'persons.address as address',
                'persons.age as age',
                'persons.gender as gender',
                'persons.created_at as created_at',
                'persons.status as status',


                'users.first_name as user_first_name',
                'users.middle_name as user_middle_name',
                'users.last_name as user_last_name',
                'users.extension as user_extension',
                'users.user_id as user_id'
            )
            ->where('persons.person_id', $id)
            ->first();
    }

    //Admin

    //Dashboard
    public function QueryPersonDashboard()
    {
        $rows = DB::connection($this->conn_dts)->table('persons as persons')
            ->select(
                //Employee
                DB::raw('COUNT(IF(persons.status = "active", 1, NULL)) as approved'),
                DB::raw('COUNT(IF(persons.status = "inactive", 1, NULL)) as removed'),
                DB::raw('COUNT(IF(persons.status = "not-approved", 1, NULL)) as pending'),
                DB::raw('COUNT(IF(persons.gender = "male", 1, NULL)) as male'),
                DB::raw('COUNT(IF(persons.gender = "female", 1, NULL)) as female'),
            )
            ->get();
        return $rows;
    }


    public function added_today($date_now)
    {

        return DB::connection($this->conn_dts)->table('persons')
            ->whereDate('persons.created_at', '=', $date_now)
            ->orderBy('persons.first_name', 'asc')->get();
    }

    public function approved_today($date_now)
    {

        return DB::connection($this->conn_dts)->table('persons')
            ->where('persons.status', 'active')
            ->whereDate('persons.created_at', '=', $date_now)
            ->orderBy('persons.first_name', 'asc')->get();
    }

    public function latest_approved($limit)
    {

        return DB::connection($this->conn_dts)->table('persons')
            ->where('persons.status', 'active')
            ->orderBy('persons.person_id', 'desc')->limit($limit)->get();
    }

    public function count_gender_by_month($month, $year, $gender)
    {

        return DB::connection($this->conn_dts)->table('persons')
            ->where('gender', $gender)
            ->where('persons.status', 'active')
            ->whereMonth('persons.created_at', $month)
            ->whereYear('created_at', $year)
            ->count();

    }


    public function QueryToApprove()
    {

        return DB::table($this->dts_table_name . '.persons as persons')
            ->leftJoin($this->users_table_name . '.users as users', 'users.user_id', '=', 'persons.added_by')
            ->select(
                'persons.person_id as person_id',
                'persons.first_name as first_name',
                'persons.middle_name as middle_name',
                'persons.last_name as last_name',
                'persons.extension as extension',

                'persons.phone_number as phone_number',
                'persons.email_address as email_address',
                'persons.address as address',
                'persons.age as age',
                'persons.created_at as created_at',
                'persons.status as status',


                'users.first_name as user_first_name',
                'users.middle_name as user_middle_name',
                'users.last_name as user_last_name',
                'users.extension as user_extension',
                'users.user_id as user_id'
            )
            ->where('persons.status', 'not-approved')
            ->orderBy('persons.first_name', 'asc')->get();

    }

    public function QueryActivityLogs()
    {
        $row = DB::table($this->dts_table_name . '.action_logs')
            ->leftJoin($this->users_table_name . '.users', 'users.user_id', '=', 'action_logs.user_id')
            ->leftJoin($this->dts_table_name . '.persons', 'persons.person_id', '=', 'action_logs._id')

            ->select(   //history

                'action_logs.action_datetime as action_datetime',
                'action_logs.action as action',
                'action_logs.user_type as user_type',
                'action_logs._id as _id',
                //Persons
                'persons.first_name as first_name',
                'persons.middle_name as middle_name',
                'persons.last_name as last_name',
                'persons.extension as extension',
                'persons.person_id as person_id',
                //User
                'users.first_name as first_name',
                'users.middle_name as middle_name',
                'users.last_name as last_name',
                'users.extension as extension',
            )
            ->where('action_logs.web_type', 'wl')
            ->orderBy('action_logs.action_datetime', 'desc')
            ->get();
        return $row;
    }

}
