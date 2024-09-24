<?php

namespace App\Http\Controllers\systems\lls_whip\both;

use App\Http\Controllers\Controller;
use App\Http\Requests\lls\EmployeeStoreRequest;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Repositories\lls\EmployeeQuery;
use App\Services\CustomService;
use App\Services\lls\EstablishmentService;
use App\Services\user\UserService;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    protected $customRepository;
    protected $employeeQuery;
    protected $customService;
    protected $establishmentService;
    protected $conn;
    protected $est_employee_table;
    protected $employee_table;
    protected $order_by_asc = 'asc';
    protected $order_by_desc = 'desc';
    protected $order_by_key = 'estab_emp_id';
    protected $default_city_code;
    protected $default_city_name;
    protected $userService;
    public function __construct(CustomRepository $customRepository, EmployeeQuery $employeeQuery, CustomService $customService, EstablishmentService $establishmentService, UserService $userService){
        $this->customRepository     = $customRepository;
        $this->employeeQuery        = $employeeQuery;
        $this->customService        = $customService;
        $this->establishmentService = $establishmentService;
        $this->userService          = $userService;
        $this->conn                 = config('custom_config.database.lls_whip');
        $this->employee_table       = 'employees';
        $this->est_employee_table   = 'establishment_employee';
        $this->default_city_code         = '1004209000';
        $this->default_city_name         = 'City of Oroquieta';
    }

    public function index(Request $request){
        $data['title'] = 'Employees Records';
        $segments = $request->segments();
        if($segments[1] == 'lls') {
            return view('systems.lls_whip.lls.both.employees.lists')->with($data);
        }else if($segments[1] == 'whip') {
            return view('systems.lls_whip.whip.both.employees.lists')->with($data);
        }
    }


    // CREATE


    public function insert_employee(EmployeeStoreRequest $employeeStoreRequest){

         $row = $employeeStoreRequest->validated();
         
        $items  = array(
            'first_name'            => $row['first_name'],
            'last_name'             => $row['last_name'],
            'extension'             => $row['extension'],
            'street'                => $row['street'],
            'barangay'              => empty($row['barangay']) ? NULL : explode('-',$row['barangay'])[1],
            'barangay_code'         => empty($row['barangay']) ? NULL : explode('-',$row['barangay'])[0],
            'city'                  => explode('-',$row['city'])[1],
            'city_code'             => explode('-',$row['city'])[0],
            'province'              => explode('-',$row['province'])[1],
            'province_code'         => explode('-',$row['province'])[0],
            'gender'                => $row['gender'],
            'contact_number'        => $row['contact_number'],
            'birthdate'             => $row['birthdate'],
            'created_on'            => Carbon::now()->format('Y-m-d H:i:s'),
        );

        
        $insert = $this->customRepository->insert_item($this->conn,$this->employee_table,$items);
        if ($insert) {
            // Registration successful
            return response()->json([
                'message' => 'Employee Added Successfully', 
                'response' => true
            ], 201);
        }else {
            return response()->json([
                'message' => 'Something Wrong', 
                'response' => false
            ], 422);
        }     
      
    }

    // READ
    public function get_all_employees(){
        $es = $this->customRepository->q_get_order($this->conn,$this->employee_table,'employee_id',$this->order_by_desc)->get();
        $items = [];
        foreach ($es as $row) {
           $items[] = array(
                    'employee_id'           => $row->employee_id,
                    'gender'                => $row->gender,
                    'full_name'             => $this->userService->user_full_name($row),
                    'full_address'          => $this->userService->full_address($row),
                    'contact_number'        => $row->contact_number,
                    'birthdate'            => date('M d Y', strtotime($row->birthdate)),
                    'created'               => date('M d Y - h:i a', strtotime($row->created_on)),
           );
        }
        return response()->json($items);
    }

    public function whip_profile($id){
        $count = $this->customRepository->q_get_where($this->conn,array('employee_id' => $id),$this->employee_table);
        if($count->count() > 0){

            $row = $count->first();
            $data['title']  = $this->userService->user_full_name($row);
            $data['row']    = $row;
            $data['job_info'] = $this->employeeQuery->QueryWHIPEmployeeJobHistory($id);
            return view('systems.lls_whip.whip.admin.pages.employee_profile.employee_profile')->with($data);

        }else {
            echo '404';
        }
    }

    public function lls_profile($id){
        $count = $this->customRepository->q_get_where($this->conn,array('employee_id' => $id),$this->employee_table);
        if($count->count() > 0){

            $row = $count->first();
            $data['title']  = $this->userService->user_full_name($row);
            $data['row']    = $row;
            $data['job_info'] = $this->employeeQuery->QueryLLSEmployeeJobHistory($id);
            return view('systems.lls_whip.lls.both.employee_info.employee_info')->with($data);

        }else {
            echo '404';
        }
    }
    // UPDATE
    public function update_employee(Request $request){
        $where = array('employee_id' => $request->input('employee_id'));
        $update = $this->customRepository->update_item($this->conn,$this->employee_table,$where,$request->all());
        if ($update) {
            // Registration successful
            return response()->json([
                'message' => 'Employee Updated Successfully', 
                'response' => true
            ], 201);
        }else {
            return response()->json([
                'message' => 'Something Wrong/No Changes Apply', 
                'response' => false
            ], 422);
        }
    }   
    // DELETE
    public function delete_employee(Request $request)
    {

        $id = $request->input('id')['id'];
        if (is_array($id)) {
            foreach ($id as $row) {
               $where = array('employee_id' => $row);
               $this->customRepository->delete_item($this->conn,$this->employee_table,$where);
               $this->customRepository->delete_item($this->conn,'establishment_employee',$where);
               $this->customRepository->delete_item($this->conn,'project_employee',$where);
            }
            $this->customRepository->delete_item($this->conn,$this->est_employee_table,$where);
            $data = array('message' => 'Deleted Succesfully', 'response' => true);
        } else {
            $data = array('message' => 'Error', 'response' => false);
        }



        return response()->json($data);
    }

    //SEARCH
    
    public function search_employee(){
        $q = trim($_GET['key']);
        $emp = $this->employeeQuery->q_search($q);
        $data = [];
        foreach ($emp as $row) {
            $data[] = array(
                'employee_id'   => $row->employee_id,
                'first_name'    => $row->first_name,
                'middle_name'   => $row->middle_name == null ? ' ' : $row->middle_name,
                'last_name'     => $row->last_name,
                'extension'     => $row->extension == null ? ' ' : $row->extension,
                'full_address'  => $this->userService->full_address($row),
                'barangay'      => $row->barangay
            );
        }
        return response()->json($data);
    }

}
