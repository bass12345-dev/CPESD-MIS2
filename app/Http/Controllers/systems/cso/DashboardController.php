<?php

namespace App\Http\Controllers\systems\cso;
use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use App\Repositories\pmas\user\UserPmasQuery;
use App\Services\CustomService;
use App\Services\user\UserService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    protected $conn;
    protected $customRepository;
    protected $customService;
    protected $userService;

    protected $userPmasQuery;

    public function __construct(CustomRepository $customRepository, CustomService $customService, UserService $userService,UserPmasQuery $userPmasQuery)
    {

        $this->customRepository = $customRepository;
        $this->userPmasQuery    = $userPmasQuery;
        $this->customService = $customService;
        $this->userService = $userService;
        $this->conn = config('custom_config.database.pmas');

    }
    public function index()
    {
        $data['title'] = 'CSO Dashboard';
        $data['count_po'] = $this->customRepository->q_get_where($this->conn, array('type_of_cso' => 'PO'), 'cso')->count();
        $data['count_coop'] = $this->customRepository->q_get_where($this->conn, array('type_of_cso' => 'Coop'), 'cso')->count();
        $data['count_nsc'] = $this->customRepository->q_get_where($this->conn, array('type_of_cso' => 'NSC'), 'cso')->count();
        return view('systems.cso.pages.dashboard.dashboard')->with($data);
    }

    public function count_cso_per_barangay(){

        $barangay = config('custom_config.barangay');
        $data = [];
        foreach($barangay as $row) {
            $data[] = array(

                    'barangay' => $row,
                    'active' => $this->customRepository->q_get_where($this->conn,array('barangay' => $row , 'cso_status' => 'active'),'cso')->count(),
                    'inactive' => $this->customRepository->q_get_where($this->conn,array('barangay' => $row , 'cso_status' => 'inactive'),'cso')->count(),

                );

        }

        return response()->json($data);

    }




}
