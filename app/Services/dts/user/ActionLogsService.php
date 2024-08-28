<?php

namespace App\Services\dts\user;

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
    protected $dtsQuery;
    protected $customService;
    protected $actionLogService;

    public function __construct(CustomRepository $customRepository, DtsQuery $dtsQuery, CustomService $customService, ActionLogService $actionLogService)
    {
        $this->conn = config('custom_config.database.dts');
        $this->conn_user = config('custom_config.database.users');
        $this->customRepository = $customRepository;
        $this->customService = $customService;
        $this->actionLogService = $actionLogService;
        $this->dtsQuery = $dtsQuery;

        $this->user_table = 'users';
    }

    public function UserActionLogs($month, $year)
    {
        if ($month == '' && $year == '') {
            $items = $this->dtsQuery->QueryActionLogs();
        } else {
            $items = $this->dtsQuery->QueryActionLogsPerMonth($month, $year);
        }
        $data = [];
        $i = 1;
        foreach ($items as $value => $key) {
            $data[] = array(
                'number'            => $i++,
                'tracking_number'   => $key->tracking_number,
                'action'            => $key->action,
                'action_datetime'   => date('M d Y h:i A', strtotime($key->action_datetime))
                
            );
        }
        return $data;
    }

 
}
