<?php

namespace App\Services\whip;

use App\Repositories\CustomRepository;
use Carbon\Carbon;

class ProjectsService
{
    
    protected $conn;
    protected $customRepository;
    protected $projects_table;
    protected $project_employee_table;
    public function __construct(CustomRepository $customRepository){
        $this->conn                 = config('custom_config.database.lls_whip');
        $this->customRepository     = $customRepository;
        $this->projects_table       = 'projects';
        $this->project_employee_table = 'project_employee';
    }
    

    //REGISTER PROJECT
    public function registerProj(array $item)
    {

        $items = array(
            'contractor_id'         => $item['contractor_id'],
            'project_title'         => $item['project_title'],
            'project_cost'          => $item['project_cost'],
            'street'                => $item['street'],
            'barangay'              => $item['barangay'],
            'project_status'        => 'ongoing',
            'date_started'          => $item['date_started'],
            'project_nature_id'     => $item['project_nature_id'],
            'created_on'            => Carbon::now()->format('Y-m-d H:i:s'),
            
        );
        $user = $this->customRepository->insert_item($this->conn,$this->projects_table,$items);
        return $user;
    }


    //Project Employee

    public function insert_project_employee(array $items ){
        $data = [];
        $count = $this->customRepository->q_get_where($this->conn,array('employee_id' => $items['employee_id'],'project_id' => $items['project_id'],'project_monitoring_id' => $items['project_monitoring_id']),$this->project_employee_table,)->count();
        $items["created_on"] = Carbon::now()->format('Y-m-d H:i:s');
        if($count == 0) {
            $items["created_on"] = Carbon::now()->format('Y-m-d H:i:s');
            $insert = $this->customRepository->insert_item($this->conn,$this->project_employee_table,$items);
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

    public function update_project_employee(array $where,array $items){

        $update = $this->customRepository->update_item($this->conn,$this->project_employee_table,$where,$items);

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