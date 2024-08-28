<?php

namespace App\Services\dts\admin;

use App\Repositories\CustomRepository;
use App\Repositories\dts\AdminDtsQuery;
use App\Repositories\dts\DtsQuery;
use App\Services\user\ActionLogService;
use App\Services\CustomService;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LoggedInService
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

    public function logged_in($month, $year)
    {
        if ($month == '' && $year == '') {
            $items =  $this->adminDtsQuery->QueryLoggedInHistory();
        } else {
            $items =  $this->adminDtsQuery->QueryLoggedInHistoryByMonth($month, $year);
        }
        $i = 1;
        $data = [];
        foreach ($items as $value => $key) {
            $data[] = array(
                'number'            => $i++,
                'name'              => $key->first_name . ' ' . $key->middle_name . ' ' . $key->last_name . ' ' . $key->extension,
                'datetime'   => date('M d Y h:i a', strtotime($key->logged_in_date))

            );
        }

        return $data;
    }
}
