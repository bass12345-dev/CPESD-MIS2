<?php

namespace App\Http\Controllers\systems\lls_whip\lls\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Repositories\lls\EmployeeQuery;

class DashboardController extends Controller
{

    protected $conn;
    protected $customRepository;
    protected $employeeQuery;
    public function __construct(CustomRepository $customRepository,EmployeeQuery $employeeQuery)
    {
        $this->conn                 = config('custom_config.database.lls_whip');
        $this->customRepository     = $customRepository;
        $this->employeeQuery        = $employeeQuery;
      
    }
    
    public function index(){

        $data['title']              = 'User Dashboard';
        $data['establishments']     = $this->customRepository->q_get($this->conn, 'establishments')->count();
        $data['positions']          = $this->customRepository->q_get_where($this->conn, array('type' => 'lls'), 'positions')->count();
        $data['employee_positions'] = $this->employeeQuery->QueryPositionsCount();
        $data['total_establishment_employee'] = $this->employeeQuery->QueryEstablishmentEmployeeTotal();
        return view('systems.lls_whip.lls.user.pages.dashboard.dashboard')->with($data);
    }


    public function get_gender_inside(){
        $res = $this->employeeQuery->QueryGenderInside();
        $gender = [];
        $total = [];
        foreach ($res as $row) {
            $gender[] = $row->gender;
            $total[] = $row->g;
        }
       $data['label'] = $gender;
       $data['total']    = $total;
       $data['color'] = ['rgb(41,134,204)','rgb(201,0,118)'];
       return response()->json($data);
    }

    public function get_gender_outside(){
        $res = $this->employeeQuery->QueryGenderOutside();
        $gender = [];
        $total = [];
        foreach ($res as $row) {
            $gender[] = $row->gender;
            $total[] = $row->g;
        }
       $data['label'] = $gender;
       $data['total']    = $total;
       $data['color'] = ['rgb(41,134,204)','rgb(201,0,118)'];
       return response()->json($data);
    }
}
