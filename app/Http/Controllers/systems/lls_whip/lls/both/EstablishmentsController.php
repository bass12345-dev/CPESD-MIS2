<?php

namespace App\Http\Controllers\systems\lls_whip\lls\both;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\EstablishmentStoreRequest;
use App\Services\lls\EstablishmentService;
use App\Repositories\CustomRepository;
use App\Repositories\lls\EmployeeQuery;
use App\Services\user\UserService;
use Carbon\Carbon;


class EstablishmentsController extends Controller
{
    protected $conn;
    protected $establishmentService;

    protected $userService;
    protected $customRepository;
    protected $employeeQuery;
    protected $establishments_table;
    protected $order_by_asc = 'asc';
    protected $order_by_key = 'establishment_code';
    protected $default_city;
    public function __construct(EstablishmentService $establishmentService, CustomRepository $customRepository, EmployeeQuery $employeeQuery, UserService $userService)
    {
        $this->establishmentService = $establishmentService;
        $this->userService = $userService;
        $this->customRepository = $customRepository;
        $this->employeeQuery = $employeeQuery;
        $this->conn = config('custom_config.database.lls_whip');
        $this->establishments_table = 'establishments';
        $this->default_city = config('custom_config.default_city');
    }
    public function add_new_establishments()
    {

        $data['title'] = 'Add New Establishment';
        $data['barangay'] = config('custom_config.barangay');
        return view('systems.lls_whip.lls.both.establishments.add_new.add_new')->with($data);
    }


    public function establishments_list()
    {

        $data['title'] = 'Establishment List';
        return view('systems.lls_whip.lls.both.establishments.lists.lists')->with($data);
    }


    public function establishments_view_information($id)
    {
        $row = $this->customRepository->q_get_where($this->conn, array('establishment_id' => $id), $this->establishments_table)->first();
        $data['row'] = $row;
        $data['year_now'] = Carbon::now()->format('Y');
        $data['barangay'] = config('custom_config.barangay');
        $data['title'] = $row->establishment_name;
        $data['level_of_employment'] = config('custom_config.level_of_employment');
        $data['nature_of_employment'] = config('custom_config.lls_nature_of_employment');
        $data['positions'] = $this->customRepository->q_get_where_order($this->conn, 'positions', array('type' => 'lls'), 'position', 'asc')->get();
        $data['employment_status'] = $this->customRepository->q_get_order($this->conn, 'employment_status', 'status', 'asc')->get();
        return view('systems.lls_whip.lls.both.establishments.view.view')->with($data);
    }




    //CREATE
    public function insert_establishment(EstablishmentStoreRequest $request)
    {

        $validatedData = $request->validated();
        $resp = $this->establishmentService->registerES($validatedData);

        if ($resp) {
            return response()->json([
                'message' => 'Establishment Added Successfully',
                'response' => true
            ], 201);
        } else {
            return response()->json([
                'message' => 'Something Wrong',
                'response' => false
            ], 422);
        }
    }
    //READ
    public function get_all_establishment()
    {
        $es = $this->customRepository->q_get_order($this->conn, $this->establishments_table, $this->order_by_key, $this->order_by_asc)->get();
        $items = [];
        foreach ($es as $row) {
            $items[] = array(
                'establishment_id'          => $row->establishment_id,
                'establishment_code'        => $row->establishment_code,
                'establishment_name'        => $row->establishment_name,
                'contact_number'            => $row->contact_number,
                'telephone_number'          => $row->telephone_number,
                'full_address'              => $this->establishmentService->establishment_full_address($row),
                'email_address'             => $row->email_address,
                'authorized_personnel'      => $row->authorized_personnel,
                'position'                  => $row->position,
                'status'                    => $row->status,

            );
        }

        return response()->json($items);
    }
    //UPDATE
    public function update_establishment(Request $request)
    {

        $resp = $this->establishmentService->Update_Establishment($request);
        if ($resp) {
            // Registration successful
            return response()->json([
                'message' => 'Establishment Updated Successfully',
                'response' => true
            ], 201);
        } else {
            return response()->json([
                'message' => 'Something Wrong/No Changes Applied',
                'response' => false
            ], 422);
        }

    }
    //DELETE
    public function delete_establishment(Request $request)
    {

        $id = $request->input('id')['id'];
        if (is_array($id)) {
            foreach ($id as $row) {
                $where = array('establishment_id' => $row);
                $this->customRepository->delete_item($this->conn, $this->establishments_table, $where);
                $this->customRepository->delete_item($this->conn,'establishment_employee',$where);
            }

            $data = array('message' => 'Deleted Succesfully', 'response' => true);
        } else {
            $data = array('message' => 'Error', 'response' => false);
        }



        return response()->json($data);
    }


    public function delete_establishment_employee(Request $request)
    {

        $id = $request->input('id')['id'];
        if (is_array($id)) {
            foreach ($id as $row) {
               $where = array('employee_id' => $row);
               $this->customRepository->delete_item($this->conn,'establishment_employee',$where);
            }

            $data = array('message' => 'Deleted Succesfully', 'response' => true);
        } else {
            $data = array('message' => 'Error', 'response' => false);
        }



        return response()->json($data);
    }


    //Employees

    public function insert_or_update_establishment_employee(Request $request)
    {

        $items = array(
            'establishment_id'          => $request->input('establishment_id'),
            'employee_id'               => $request->input('employee_id'),
            'position_id'               => $request->input('position'),
            'nature_of_employment'      => $request->input('employment_nature'),
            'status_of_employment_id'   => $request->input('employment_status'),
            'level_of_employment'       => $request->input('employment_level'),
            'start_date'                => $request->input('start') == NULL ? NULL : Carbon::parse($request->input('start'))->format('Y-m-d'),
            'end_date'                  => $request->input('end') == NULL ? NULL : Carbon::parse($request->input('end'))->format('Y-m-d'),
        );

        if ($items['start_date'] <= $items['end_date'] || empty($items['end_date'])) {

            if (empty($request->input('establishment_employee_id'))) {
                $resp = $this->establishmentService->insert_establishment_employee($items);

            } else {
                $where = array('employee_id' => $request->input('establishment_employee_id'));
                $resp = $this->establishmentService->update_establishment_employee($where, $items);
            }

        } else {
            $resp = [
                'message' => 'Start Date is greater than End Date',
                'response' => false
            ];
        }



        return response()->json($resp);

    }

    public function get_establishment_employees(Request $request)
    {
        $id = $request->input('id');
        $filter_date = $request->input('filter_date');
        $resp = $this->establishmentService->establishment_employee($id,$filter_date);
        return response()->json($resp);


        
    }



    //GENDER

    public function get_gender_establishment_inside(Request $request) {  
        $id = $request->input('id');
        $res = $this->employeeQuery->gender_inside($id,$this->default_city);
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


    public function get_gender_establishment_outside(Request $request) {  
        $id = $request->input('id');
        $res = $this->employeeQuery->gender_outside($id,$this->default_city);
        $gender = [];
        $total = [];
        foreach ($res as $row) {
            $gender[] = $row->gender;
            $total[] = $row->g ;
        }
       $data['label'] = $gender;
       $data['total']    = $total;
       $data['color'] = ['rgb(41,134,204)','rgb(201,0,118)'];
       return response()->json($data);
       
    }
    


    public function get_establishment_positions(Request $request) {  
        $id = $request->input('id');
        $res = $this->employeeQuery->establishment_positions($id);
        $gender = [];
        $total = [];
        foreach ($res as $row) {
            $gender[] = $row->position;
            $total[] = $row->c ;
        }
       $data['label'] = $gender;
       $data['total']    = $total;
       $data['color'] = ['rgb(41,134,204)','rgb(201,0,118)'];
       return response()->json($data);
       
    }

    //GENERATE REPORT
    public function generate_compliant_report(Request $request){
        $year = $request->input('date').'-01';
        $data = $this->establishmentService->compliant_process($year);
        return response()->json($data);
        
     }


     function generate_survey(Request $request){
        $id         = $request->input('id');
        $date       = $request->input('date').'-01';
        $data['inside'] = $this->employeeQuery->get_survey_inside($id,$date);
        $data['outside'] = $this->employeeQuery->get_survey_outside($id,$date);
        return $data;
    }

    function get_survey_employee_list(Request $request){
        $id         = $request->input('id');
        $date       = $request->input('date').'-01';
        $items = $this->employeeQuery->QueryEstablishmentEmployeeList($id,$date);
        $data = [];
        foreach ($items as $row) {
            $data[] = array(
                'establishment_employee_id'     => $row->estab_emp_id,
                'employee_id'                   => $row->employee_id,
                'full_name'                     => $this->userService->user_full_name($row),
                'full_address'                  => $this->userService->full_address($row),
                'position'                      => $row->position,
                'position_id'                   => $row->position_id,
                'nature_of_employment'          => $row->nature_of_employment,
                'status_id'                     => $row->employment_status_id,
                'status_of_employment'          => $row->status,
                'start_date'                    => $row->start_date == NULL ? '-' : Carbon::parse($row->start_date)->format('M Y'),
                'end_date'                      => $row->end_date == NULL ? '-' : Carbon::parse($row->end_date)->format('M Y'),
                'level_of_employment'           => $row->level_of_employment,
                'gender'                        => $row->gender
            );
        }
        return response()->json($data);
      
    }


    

}
