<?php

namespace App\Http\Controllers\systems\lls_whip\lls\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
class DashboardController extends Controller
{

    protected $conn;
    protected $customRepository;
    public function __construct(CustomRepository $customRepository)
    {
        $this->conn                 = config('custom_config.database.lls_whip');
        $this->customRepository     = $customRepository;
      
    }
    
    public function index(){

        $data['title']              = 'User Dashboard';
        $data['establishments']  = $this->customRepository->q_get($this->conn, 'establishments')->count();
        $data['positions']  = $this->customRepository->q_get_where($this->conn, array('type' => 'lls'), 'positions')->count();
        return view('systems.lls_whip.lls.user.pages.dashboard.dashboard')->with($data);
    }
}
