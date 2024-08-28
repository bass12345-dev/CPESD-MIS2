<?php

namespace App\Services\whip;

use App\Repositories\CustomRepository;
use Carbon\Carbon;

class ContractorsService
{

    protected $conn;
    protected $customRepository;
    protected $contractors_table;
    protected $contractor_employee_table;
    public function __construct(CustomRepository $customRepository)
    {
        $this->conn                         = config('custom_config.database.lls_whip');
        $this->customRepository             = $customRepository;
        $this->contractors_table            = 'contractors';
        $this->contractor_employee_table    = 'contractor_employee';
    }


    //REGISTER USER
    public function registerContractor(array $row)
    {

        $items = array(
            'contractor_name'       => $row['contractor_name'],
            'proprietor'            => $row['proprietor'],
            'street'                => $row['street'],
            'barangay'              => empty($row['barangay']) ? NULL : explode('-',$row['barangay'])[1],
            'barangay_code'         => empty($row['barangay']) ? NULL : explode('-',$row['barangay'])[0],
            'city'                  => explode('-',$row['city'])[1],
            'city_code'             => explode('-',$row['city'])[0],
            'province'              => explode('-',$row['province'])[1],
            'province_code'         => explode('-',$row['province'])[0],
            'phone_number'          => $row['phone_number'],
            'phone_number_owner'    => $row['phone_number_owner'],
            'telephone_number'      => $row['telephone_number'],
            'email_address'         => $row['email_address'],
            'status'                => 'active',
            'added_by'              => session('user_id'),
            'created_on'            => Carbon::now()->format('Y-m-d H:i:s'),

        );
        $user = $this->customRepository->insert_item($this->conn, $this->contractors_table, $items);
        return $user;
    }


    public function insert_contractor_employee(array $items)
    {
        $data = [];;
        $count = $this->customRepository->q_get_where($this->conn, array('employee_id' => $items['employee_id'], 'contractor_id' => $items['contractor_id']), $this->contractor_employee_table)->count();
        if ($count == 0) {
            $items["created_on"] = Carbon::now()->format('Y-m-d H:i:s');
            $insert = $this->customRepository->insert_item($this->conn, $this->contractor_employee_table, $items);
            if ($insert) {
                // Registration successful
                $data = [
                    'message' => 'Employee Added Successfully',
                    'response' => true
                ];
            } else {
                $data = [
                    'message' => 'Something Wrong',
                    'response' => false
                ];
            }
        } else {
            $data = [
                'message' => 'Duplicate Entry',
                'response' => false
            ];
        }
        return $data;
    }


    public function update_establishment_employee(array $where,array $items){
        $update = $this->customRepository->update_item($this->conn,$this->contractor_employee_table,$where,$items);

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


}
