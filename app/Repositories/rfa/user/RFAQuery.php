<?php

namespace App\Repositories\rfa\user;

use Illuminate\Support\Facades\DB;

class RFAQuery
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
        $row = DB::connection($this->conn)->table('rfa_transactions')
            ->where('reffered_to', session('user_id'))
            ->where('rfa_status', $status)
            ->whereMonth('rfa_date_filed', '=', $month)
            ->whereYear('rfa_date_filed', '=', $year)
            ->count();
        return $row;

    }

    //RFA DATA

    public function QueryRFAData($id)
    {

        $row = DB::table($this->pmas_db_name . '.rfa_transactions as rfa_transactions')
            ->leftJoin($this->pmas_db_name . '.type_of_request', 'type_of_request.type_of_request_id', '=', 'rfa_transactions.tor_id')
            ->leftJoin($this->pmas_db_name . '.rfa_clients', 'rfa_clients.rfa_client_id', '=', 'rfa_transactions.client_id')
            ->leftJoin($this->users_db_name . '.users', 'users.user_id', '=', 'rfa_transactions.rfa_created_by')

            ->select(
                //Contractors
                'rfa_transactions.rfa_date_filed as rfa_date_filed',
                'rfa_transactions.rfa_id as rfa_id',
                'rfa_transactions.rfa_date_filed as rfa_date_filed',
                'rfa_transactions.number as number',
                'rfa_transactions.reffered_to as reffered_to',
                'rfa_transactions.tor_id as tor_id',


                'rfa_clients.rfa_client_id as rfa_client_id',
                'rfa_clients.first_name as client_first_name',
                'rfa_clients.middle_name as client_middle_name',
                'rfa_clients.last_name as client_last_name',
                'rfa_clients.extension as client_extension',
                'rfa_clients.purok as client_purok',
                'rfa_clients.barangay as client_barangay',



                'type_of_request.type_of_request_name as type_of_request_name',
                'type_of_request.type_of_request_id as type_of_request_id',

                'rfa_transactions.type_of_transaction as type_of_transaction',




            )
            ->where('rfa_transactions.rfa_id', $id)
            ->where('rfa_transactions.rfa_status', 'pending')
            ->where('rfa_transactions.rfa_created_by', session('user_id'))
            ->orderBy('rfa_transactions.rfa_date_filed', 'desc')
            ->first();
        return $row;


    }


    //Pending Transactions
    public function QueryUserPendingRFA()
    {

        $row = DB::table($this->pmas_db_name . '.rfa_transactions as rfa_transactions')
            ->leftJoin($this->pmas_db_name . '.type_of_request', 'type_of_request.type_of_request_id', '=', 'rfa_transactions.tor_id')
            ->leftJoin($this->users_db_name . '.users', 'users.user_id', '=', 'rfa_transactions.rfa_created_by')
            ->where('rfa_transactions.rfa_status', 'pending')
            ->where('rfa_transactions.rfa_created_by', session('user_id'))
            ->orderBy('rfa_transactions.rfa_date_filed', 'desc')
            ->get();
        return $row;

    }


    //REferred Transactions

    public function QueryUserReferredRFA()
    {


        $row = DB::table($this->pmas_db_name . '.rfa_transactions as rfa_transactions')
            ->leftJoin($this->pmas_db_name . '.type_of_request', 'type_of_request.type_of_request_id', '=', 'rfa_transactions.tor_id')
            ->leftJoin($this->users_db_name . '.users', 'users.user_id', '=', 'rfa_transactions.rfa_created_by')
            ->where('rfa_transactions.rfa_status', 'pending')
            ->where('rfa_transactions.reffered_to', session('user_id'))
            ->orderBy('rfa_transactions.reffered_date_and_time', 'desc')
            ->get();
        return $row;
    }

    //Completed Transactions

    public function QueryUserCompletedRFA()
    {

        $row = DB::table($this->pmas_db_name . '.rfa_transactions as rfa_transactions')
            ->leftJoin($this->pmas_db_name . '.type_of_request', 'type_of_request.type_of_request_id', '=', 'rfa_transactions.tor_id')
            ->leftJoin($this->users_db_name . '.users', 'users.user_id', '=', 'rfa_transactions.rfa_created_by')
            ->where('rfa_transactions.rfa_status', 'completed')
            ->where('rfa_transactions.reffered_to', session('user_id'))
            ->orderBy('rfa_transactions.reffered_date_and_time', 'desc')
            ->get();
        return $row;

    }

    //Add View

    public function QueryRFATransactionsLimit($limit)
    {

        $row = DB::table($this->pmas_db_name . '.rfa_transactions')
            ->leftJoin($this->users_db_name . '.users as users', 'users.user_id', '=', 'rfa_transactions.rfa_created_by')
            ->orderBy('rfa_transactions.rfa_date_filed', 'desc')
            ->limit($limit)
            ->get();
        return $row;

    }

    public function get_last_ref_number_where($where)
    {
        $row = DB::connection($this->conn)->table('rfa_transactions')
            ->whereYear('rfa_date_filed', '=', $where)
            ->orderBy('rfa_date_filed', 'desc');
        return $row;
    }

    //Search 

    public function search_client($search)
    {
        $row = DB::connection($this->conn)->table('rfa_clients')

            ->where(DB::raw("concat(first_name, ' ', last_name)"), 'LIKE', "%" . $search . "%")
            ->get();
        return $row;

    }


    public function QueryMyClients()
    {
        $row = DB::connection($this->conn)->table('rfa_transactions as rfa_transactions')
            ->leftJoin('rfa_clients', 'rfa_clients.rfa_client_id', '=', 'rfa_transactions.client_id')
            ->select(
                DB::raw('COUNT(rfa_transactions.client_id) as count'),
                'rfa_clients.rfa_client_id as rfa_client_id',
                'rfa_clients.first_name as client_first_name',
                'rfa_clients.middle_name as client_middle_name',
                'rfa_clients.last_name as client_last_name',
                'rfa_clients.extension as client_extension',
                'rfa_clients.purok as client_purok',
                'rfa_clients.barangay as client_barangay',
                'rfa_clients.gender as client_gender',
                'rfa_clients.age as client_age',
                'rfa_clients.contact_number as client_contact_number',
                'rfa_clients.employment_status as client_employment_status',
            )
            ->groupBy('rfa_transactions.client_id')
            ->where('rfa_transactions.reffered_to', session('user_id'))
            ->orderBy('rfa_clients.first_name', 'asc')
            ->get();
        return $row;



    }


}
