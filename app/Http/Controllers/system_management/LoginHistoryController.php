<?php

namespace App\Http\Controllers\system_management;

use App\Http\Controllers\Controller;
use App\Repositories\sysm\SystemQuery;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LoginHistoryController extends Controller
{   
    protected $systemQuery;
    protected $conn;
    public function __construct(SystemQuery $systemQquery){
        $this->systemQuery          = $systemQquery;
        $this->conn                 = config('app._database.users');
    }
    public function index(){
        $data['title']  = 'Logged in History';
        $data['current']    = Carbon::now()->year.'-'.Carbon::now()->month;
        return view('system_management.contents.login_history.login_history')->with($data);
    }

    public function get_all_login_logs(){

        $month = '';
        $year = '';
        if(isset($_GET['m'])){
            $month =   date('m', strtotime($_GET['m']));
            $year =   date('Y', strtotime($_GET['m']));
        }
        if($month == '' && $year == ''){
            $items =  $this->systemQuery->get_logged_in_history($this->conn);
       }else {
            $items =  $this->systemQuery->get_logged_in_history_by_month($this->conn,$month,$year);
       }
       $i = 1;
       $data = [];
       foreach ($items as $value => $key) {
        $data[] = array(
            'number'            => $i++,
            'name'              => $key->first_name . ' ' . $key->middle_name . ' ' . $key->last_name . ' ' . $key->extension,
            'datetime'   => date('M d Y h:i a',strtotime($key->logged_in_date))
            
        );
    }
        return response()->json($data);

    }
}