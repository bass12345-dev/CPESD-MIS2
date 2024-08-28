<?php

namespace App\Http\Controllers\systems\dts\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Services\dts\admin\LoggedInService;
use Carbon\Carbon;

class LoggedInController extends Controller
{
    protected $conn;
    protected $customRepository;
    protected $loggedInService;
    public function __construct(CustomRepository $customRepository,LoggedInService  $loggedInService)
    {
        $this->conn                 = config('custom_config.database.dts');
        $this->customRepository     = $customRepository;
        $this->loggedInService     = $loggedInService;
    }
        
    public function index()
    {
        $data['title']      = 'Logged in History';
        $data['current']            = Carbon::now()->year . '-' . Carbon::now()->month;
        return view('systems.dts.admin.pages.logged_in_history.logged_in_history')->with($data);
    }

    public function get_logged_in_history()
    {
        $month = '';
        $year = '';
        if (isset($_GET['date'])) {
            $month =   date('m', strtotime($_GET['date']));
            $year =   date('Y', strtotime($_GET['date']));
        }
        $user = $this->loggedInService->logged_in($month, $year);
        return response()->json($user);
    }
}
