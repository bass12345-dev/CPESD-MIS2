<?php

namespace App\Services\dts\admin;

use App\Repositories\CustomRepository;
use App\Repositories\dts\AdminDtsQuery;
use App\Repositories\dts\DtsQuery;
use App\Services\user\ActionLogService;
use App\Services\CustomService;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ActionLogsService
{

    protected $conn;
    protected $conn_user;
    protected $customRepository;
    protected $user_table;
    protected $adminDtsQuery;
    protected $customService;
    protected $actionLogService;

    public function __construct(CustomRepository $customRepository, AdminDtsQuery $adminDtsQuery, CustomService $customService, ActionLogService $actionLogService)
    {
        $this->conn = config('custom_config.database.dts');
        $this->conn_user = config('custom_config.database.users');
        $this->customRepository = $customRepository;
        $this->customService = $customService;
        $this->actionLogService = $actionLogService;
        $this->adminDtsQuery = $adminDtsQuery;

        $this->user_table = 'users';
    }

    public function AllActionLogs($month, $year)
    {
        if ($month == '' && $year == '') {
            $items = $this->adminDtsQuery->QueryAllActionLogs();
        } else {
            $items = $this->adminDtsQuery->QueryActionLogsPerMonth($month, $year);
        }

        $i                    = 1;
        $data = [];
        foreach ($items as $value => $key) {
            $data[] = array(
                'number'            => $i++,
                'name'              => $key->first_name . ' ' . $key->middle_name . ' ' . $key->last_name . ' ' . $key->extension,
                'user_type'         => $key->user_type,
                'tracking_number'   => $key->tracking_number,
                'action'            => $key->action,
                'action_datetime'   => date('M d Y h:i A', strtotime($key->action_datetime))

            );
        }

        return $data;
    }

 
}
