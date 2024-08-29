<?php

namespace App\Services\cso;

use App\Repositories\cso\CSOQuery;
use App\Repositories\CustomRepository;
use App\Repositories\pmas\user\UserPmasQuery;
use App\Services\CustomService;
use App\Services\user\ActionLogService;
use App\Services\user\UserService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CsoService
{
    protected $conn;
    protected $customRepository;
    protected $customService;
    protected $userService;
    protected $actionLogService;
    protected $userPmasQuery;
    protected $cSOQuery;

    public function __construct(CustomRepository $customRepository, CustomService $customService, UserService $userService, UserPmasQuery $userPmasQuery, ActionLogService $actionLogService, CSOQuery $cSOQuery)
    {

        $this->customRepository = $customRepository;
        $this->userPmasQuery = $userPmasQuery;
        $this->customService = $customService;
        $this->userService = $userService;
        $this->actionLogService = $actionLogService;
        $this->cSOQuery = $cSOQuery;
        $this->conn = config('custom_config.database.pmas');

    }

    public function cso_query_where($where)
    {
        $data = [];
        $item = $this->customRepository->q_get_where_order($this->conn, 'cso', $where, 'cso_code', 'desc')->get();
        foreach ($item as $row) {


            $address = '';

            if ($row->barangay == '') {

                $address = '';
                // code...
            } else if ($row->purok_number == '' && $row->barangay != '') {

                $address = $row->barangay;
            } else if ($row->purok_number != '' && $row->barangay != '') {

                $address = 'Purok ' . $row->purok_number . ' ' . $row->barangay;
            }

            $data[] = array(
                'cso_id' => $row->cso_id,
                'cso_name' => $row->cso_name,
                'cso_code' => $row->cso_code,
                'address' => $address,
                'contact_person' => $row->contact_person,
                'contact_number' => $row->contact_number,
                'telephone_number' => $row->telephone_number,
                'email_address' => $row->email_address,
                'type_of_cso' => $row->type_of_cso,
                'status' => $row->cso_status == 'active' ? '<span class="status-p bg-success">' . $row->cso_status . '</span>' : '<span class="status-p bg-danger">' . $row->cso_status . '</span>',
                'cso_status' => $row->cso_status

            );
        }

        return $data;
    }

    public function all_cso()
    {
        $data = [];
        $item = $this->customRepository->q_get_order($this->conn, 'cso', 'cso_code', 'desc')->get();
        foreach ($item as $row) {

            $address = '';

            if ($row->barangay == '') {

                $address = '';
                // code...
            } else if ($row->purok_number == '' && $row->barangay != '') {

                $address = $row->barangay;
            } else if ($row->purok_number != '' && $row->barangay != '') {

                $address = 'Purok ' . $row->purok_number . ' ' . $row->barangay;
            }

            $data[] = array(

                'cso_id' => $row->cso_id,
                'cso_name' => $row->cso_name,
                'cso_code' => $row->cso_code,
                'address' => $address,
                'contact_person' => $row->contact_person,
                'contact_number' => $row->contact_number,
                'telephone_number' => $row->telephone_number,
                'email_address' => $row->email_address,
                'type_of_cso' => strtoupper($row->type_of_cso),
                'status' => $row->cso_status == 'active' ? '<span class="status-p bg-success">' . $row->cso_status . '</span>' : '<span class="status-p bg-danger">' . $row->cso_status . '</span>',
                'cso_status' => $row->cso_status


            );
        }

        return $data;
    }



    public function AllActionLogs($month, $year)
    {


        if ($month == '' && $year == '') {
            $items = $this->cSOQuery->QueryAllActionLogs();
        } else {
            $items = $this->cSOQuery->QueryActionLogsPerMonth($month, $year);
        }

        $i = 1;
        $data = [];
        foreach ($items as $value => $key) {
            $data[] = array(
                'number' => $i++,
                'name' => $this->userService->user_full_name($key),
                'user_type' => $key->user_type,
                'action' => $key->action,
                'id'     => $key->_id,
                'action_datetime' => date('M d Y h:i A', strtotime($key->activity_log_created))

            );
        }

        return $data;
    }

}
