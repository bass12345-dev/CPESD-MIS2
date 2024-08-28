<?php

namespace App\Services\whip\user;

use App\Repositories\CustomRepository;
use App\Repositories\whip\MonitoringQuery;
use App\Services\CustomService;
use App\Services\user\UserService;
use Carbon\Carbon;

class MonitoringService
{

    protected $conn;
    protected $customService;
    protected $monitoringQuery;
    protected $customRepository;
    protected $contractors_table;
    protected $contractor_employee_table;
    protected $userService;
    public function __construct(CustomRepository $customRepository, MonitoringQuery $monitoringQuery, CustomService $customService, UserService $userService)
    {
        $this->conn                         = config('custom_config.database.lls_whip');
        $this->customRepository             = $customRepository;
        $this->monitoringQuery              = $monitoringQuery;
        $this->customService                = $customService;
        $this->userService                  = $userService;
        $this->contractors_table            = 'contractors';
        $this->contractor_employee_table    = 'contractor_employee';
    }


    public function get_my_approved_monitoring($month,$year){

        if ($month == '' && $year == '') {
            $items = $this->monitoringQuery->QueryMyApprovedMonitoring();
        } else {
            $items = $this->monitoringQuery->QueryMyApprovedMonitoringByMonth($month, $year);
        }
        $data = [];
        $i = 1;
        foreach ($items as $row) {
            $data[] = array(
                     'i'                             => $i++,
                     'project_monitoring_id'         => $row->project_monitoring_id,
                     'project_title'                 => $row->project_title,
                     'date_of_monitoring'            => date('M d Y ', strtotime($row->date_of_monitoring)),
                     'specific_activity'             => $row->specific_activity,
                     'monitoring_status'             => $row->monitoring_status,
                     'contractor'                    => $row->contractor_name,
                     'address'                       => $row->barangay.' '.$row->street,
                     'person_responsible'            => $this->userService->user_full_name($row)
                    
            );
         }

        return $data;
    }


}
