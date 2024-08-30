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
        $count_inside = $this->employeeQuery->count_inside($id,$year);
        $count_outside = $this->employeeQuery->count_outside($id,$year);
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