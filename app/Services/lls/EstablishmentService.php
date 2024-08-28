<?php

namespace App\Services\lls;

use App\Repositories\CustomRepository;
use App\Repositories\lls\EmployeeQuery;
use Carbon\Carbon;

class EstablishmentService
{
    
    protected $conn;
    protected $customRepository;
    protected $establishments_table;
    protected $establishment_employee_table;
    protected $est_employee_table;
    protected $employeeQuery;
    protected $survey_table;
    protected $default_city;
    public function __construct(CustomRepository $customRepository, EmployeeQuery $employeeQuery){
        $this->conn                 = config('custom_config.database.lls_whip');
        $this->customRepository     = $customRepository;
        $this->establishments_table = 'establishments';
        $this->survey_table         = 'survey';
        $this->establishment_employee_table = 'establishment_employee';
        $this->employeeQuery        = $employeeQuery;
        $this->default_city         = '1004209000-City of Oroquieta';
        $this->est_employee_table   = 'establishment_employee';

    }
    

    //REGISTER USER
    public function registerES(array $row)
    {

        $items = array(
            'establishment_code'     => 'ES-'.$row['establishment_code'],
            'establishment_name'     => $row['establishment_name'],
            'authorized_personnel'   => $row['authorized_personnel'],
            'position'               => $row['position'],
            'barangay'               => $row['barangay'],
            'street'                 => $row['street'],
            'contact_number'         => $row['contact_number'],
            'telephone_number'       => $row['telephone_number'],
            'email_address'          => $row['email_address'],
            'created_on'             => Carbon::now()->format('Y-m-d H:i:s'),
            'status'                 => 'active',
            'added_by'               => session('user_id')
        );
        $user = $this->customRepository->insert_item($this->conn,$this->establishments_table,$items);
        return $user;
    }


    public function Update_Establishment($row)
    {

        $where = array('establishment_id' => $row->input('establishment_id'));

        $items = array(
            'establishment_name'     => $row->input('establishment_name'),
            'authorized_personnel'   => $row->input('authorized_personnel'),
            'position'               => $row->input('position'),
            'barangay'               => $row->input('barangay'),
            'street'                 => $row->input('street'),
            'contact_number'         => $row->input('contact_number'),
            'email_address'          => $row->input('email_address'),
            'status'                 => $row->input('status'),
        );
        $user = $this->customRepository->update_item($this->conn,$this->establishments_table,$where,$items);
        return $user;
    }


    public function get_survey($id,$year){

            $arr = [];
            $natures =  config('app.lls_nature_of_employment');
            $natures_arr = [];
            $inside_data = [];
            $outside_data = [];
            foreach ($natures as $row) {
                $inside = $this->employeeQuery->get_employee_survey_by_year_inside($this->conn,$id,$year,$row[0],$this->default_city);
                $outside = $this->employeeQuery->get_employee_survey_by_year_outside($this->conn,$id,$year,$row[0],$this->default_city);
                $inside_data = array(
                    'inside_'.$row[0] => $inside,
                    // 'outside_'.$row[0] => $outside
                );
                $outside_data = array(
                    'outside_'.$row[0] => $outside,
                    // 'outside_'.$row[0] => $outside
                );

                array_push($arr,$inside_data,$outside_data);
            }

            
     

            for ($i=0; $i < count($arr); $i++) { 

                $row = array(                    
                    'inside_permanent'        => $arr[0]['inside_permanent'],
                    'outside_permanent'       => $arr[1]['outside_permanent'],
                    'inside_probationary'     => $arr[2]['inside_probationary'],
                    'outside_probationary'    => $arr[3]['outside_probationary'],
                    'inside_contractuals'     => $arr[4]['inside_contractuals'],
                    'outside_contractuals'    => $arr[5]['outside_contractuals'],
                    'inside_project_based'      => $arr[6]['inside_project_based'],
                    'outside_project_based'     => $arr[7]['outside_project_based'],
                    'inside_seasonal'           => $arr[8]['inside_seasonal'],
                    'outside_seasonal'          => $arr[9]['outside_seasonal'],
                    'inside_job_order'          => $arr[10]['inside_job_order'],
                    'outside_job_order'         => $arr[11]['outside_job_order'],
                    'inside_mgt'                => $arr[12]['inside_mgt'],
                    'outside_mgt'               => $arr[13]['outside_mgt'],
                    'inside_total'              => $this->total_inside($arr),
                    'outside_total'             => $this->total_outside($arr),
                );
            }
                
            return $row;
        
        }

        function total_inside($arr){
            return $arr[0]['inside_permanent'] + 
            $arr[8]['inside_seasonal'] + 
            $arr[2]['inside_probationary'] + 
            $arr[10]['inside_job_order'] + 
            $arr[4]['inside_contractuals'] + 
            $arr[12]['inside_mgt'] + 
            $arr[6]['inside_project_based'];
        }
    
        function total_outside($arr){
            return $arr[7]['outside_project_based'] + 
            $arr[1]['outside_permanent'] + 
            $arr[3]['outside_probationary'] + 
            $arr[5]['outside_contractuals'] + 
            $arr[9]['outside_seasonal'] + 
            $arr[11]['outside_job_order'] + 
            $arr[13]['outside_mgt'];
        }
    
    
    public function insert_establishment_employee(array $items){
            $data = [];;
            $count = $this->customRepository->q_get_where($this->conn,array('employee_id' => $items['employee_id'],'establishment_id' => $items['establishment_id']),$this->est_employee_table,)->count();
            if($count == 0) {
                $items["created_on"] = Carbon::now()->format('Y-m-d H:i:s');
                $insert = $this->customRepository->insert_item($this->conn,$this->est_employee_table,$items);
                if ($insert) {
                    // Registration successful
                    $data = [
                        'message' => 'Employee Added Successfully', 
                        'response' => true
                    ];
                }else {
                    $data = [
                        'message' => 'Something Wrong', 
                        'response' => false
                    ];
                    
                }
    
            }else {
                $data = [
                    'message' => 'Duplicate Entry', 
                    'response' => false
                ];
            }
           return $data;
        }


        public function update_establishment_employee(array $where,array $items){
            $update = $this->customRepository->update_item($this->conn,$this->est_employee_table,$where,$items);

            if ($update) {
                    // Registration successful
                    $data = [
                        'message' => 'Employee Updated Successfully', 
                        'response' => true
                    ];
                }else {
                    $data = [
                        'message' => 'Something Wrong/No Changes Applied', 
                        'response' => false
                    ];
                    
                }
           return $data;
        }

    public function Submit_Survey($row){


        $where = array('establishment_id' => $row['establishment_id'], 'year' => $row['year']);

        $row = array(    
            'establishment_id' => $row['establishment_id'],
            'year' => $row['year']  ,             
            'inside_permanent'      => $row['inside_permanent'],
            'inside_probationary'   => $row['inside_probationary'],
            'inside_contractuals'   => $row['inside_contractuals'],
            'inside_project_based'  => $row['inside_project_based'],
            'inside_seasonal'       => $row['inside_seasonal'],
            'inside_job_order'      => $row['inside_job_order'],
            'inside_mgt'            => $row['inside_mgt'],
            'outside_permanent'     => $row['outside_permanent'],
            'outside_probationary'  => $row['outside_probationary'],
            'outside_contractuals'  => $row['outside_contractuals'],  
            'outside_project_based' => $row['outside_project_based'],
            'outside_seasonal'      => $row['outside_seasonal'],
            'outside_job_order'     => $row['outside_job_order'],
            'outside_mgt'           => $row['outside_mgt'],
        );

        $count = $this->customRepository->q_get_where($this->conn,$where,$this->survey_table)->count();
        if($count > 0 ) {
            $user = $this->customRepository->update_item($this->conn,$this->survey_table,$where,$row);
        }else {
            $user = $this->customRepository->insert_item($this->conn,$this->survey_table,$row);
        }

        // $user = $this->customRepository->update_item($this->conn,$this->survey_table,$where,$row);
        return $user;


    }


    public function compliant_process($year){
        $establishments = $this->customRepository->q_get_order($this->conn,$this->establishments_table,'establishment_code','asc')->get();
        $data = [];
        foreach ($establishments as $row) {
                $data[] = array(
                    'establishment_name'    => $row->establishment_name,
                    'establishment_id'      => $row->establishment_id,
                    'is_compliant'          => $this->compliant_calc($row->establishment_id,$year),
                    // 'survey'                => $this->survey_report($row->establishment_id,$year)
                );
                
        }

       return $data;
    }
  
    function compliant_calc($id,$year){
        $count_inside = $this->employeeQuery->count_inside($this->conn,$id,$year,$this->default_city);
        $count_outside = $this->employeeQuery->count_outside($this->conn,$id,$year,$this->default_city);
        $total = $count_inside + $count_outside;
        $resp = '';
        if($total < 10){
            $resp = [
                'resp' => false,
                'percent' => 0,
                
            ];
        }else {
            $calc = round($count_inside/$total*100, 2); 
            if($calc >= 70){
                $resp = [
                    'resp' => true,
                    'percent' => $calc.'%',
                   
                   
                ];
                
            }else {
                $resp = [
                    'resp' => false,
                    'percent' => $calc.'%',
                   
                ];
                
            }
        }

        $resp['total_employee'] = $total;
        $resp['total_inside'] = $count_inside;
        return $resp;
    }



    public function establishment_full_address($row){
        
        $street     = $row->street == NULL ? ' ' : $row->street.' , ';
        $barangay   = $row->barangay == NULL ? ' ' : $row->barangay;
        return $street.$barangay;        
    }


}