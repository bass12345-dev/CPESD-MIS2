<?php
namespace App\Services\user;
use App\Repositories\CustomRepository;
use Carbon\Carbon;
class ActionLogService
{
    protected $customRepository;
    protected $now;
    protected $conn;
    protected $conn_pmas;
    public function __construct(CustomRepository $customRepository)
    {
        $this->conn = config('custom_config.database.dts');
        $this->conn_pmas = config('custom_config.database.pmas');
        $this->now = Carbon::now();
        $this->customRepository = $customRepository;

    }

    public function dts_add_action($action, $user_type, $_id)
    {

        $items = array(
            'action' => $action,
            'web_type' => 'dts',
            'user_type' => $user_type,
            'user_id' => session('user_id'),
            '_id' => $_id,
            'action_datetime' => Carbon::now()->format('Y-m-d H:i:s'),

        );

        $this->customRepository->insert_item($this->conn, 'action_logs', $items);
    }

    public function wl_add_action($action, $user_type, $_id)
    {

        $items = array(
            'action' => $action,
            'web_type' => 'wl',
            'user_type' => $user_type,
            'user_id' => session('user_id'),
            '_id' => $_id,
            'action_datetime' => Carbon::now()->format('Y-m-d H:i:s'),

        );

        $this->customRepository->insert_item($this->conn, 'action_logs', $items);


    }


    public function add_pmas_rfa_action($type,$item_id,$action)
    {

        $action_logs = array(

            'user_id' => session('user_id'),
            'type' => $type,
            '_id' => $item_id,
            'action' => $action,
            'activity_log_created' => Carbon::now()->format('Y-m-d H:i:s'),
        );

        $this->customRepository->insert_item($this->conn_pmas, 'activity_logs', $action_logs);
    }



}