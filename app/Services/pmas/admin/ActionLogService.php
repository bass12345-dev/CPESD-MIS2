<?php

namespace App\Services\pmas\admin;
use App\Repositories\CustomRepository;
use App\Repositories\pmas\admin\AdminPmasQuery;
use App\Repositories\pmas\user\UserPmasQuery;
use App\Services\CustomService;
use App\Services\user\UserService;

class ActionLogService
{
    protected $conn;
    protected $customRepository;
    protected $customService;
    protected $userService;
    protected $userPmasQuery;
    protected $adminPmasQuery;

    public function __construct(CustomRepository $customRepository, CustomService $customService, UserService $userService, UserPmasQuery $userPmasQuery, AdminPmasQuery $adminPmasQuery)
    {

        $this->customRepository = $customRepository;
        $this->userPmasQuery = $userPmasQuery;
        $this->customService = $customService;
        $this->userService = $userService;
        
        $this->adminPmasQuery = $adminPmasQuery;
        $this->conn = config('custom_config.database.pmas');

    }

    public function AllActionLogs($month, $year)
    {


        if ($month == '' && $year == '') {
            $items = $this->adminPmasQuery->QueryAllActionLogs();
        } else {
            $items = $this->adminPmasQuery->QueryActionLogsPerMonth($month, $year);
        }

        $i                    = 1;
        $data = [];
        foreach ($items as $value => $key) {
            $data[] = array(
                'number'            => $i++,
                'name'              => $this->userService->user_full_name($key),
                'user_type'         => $key->user_type,
                'action'            => $key->action,
                'action_datetime'   => date('M d Y h:i A', strtotime($key->activity_log_created))

            );
        }

        return $data;
    }


}
