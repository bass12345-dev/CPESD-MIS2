<?php

namespace App\Services\pmas\admin;
use App\Repositories\CustomRepository;
use App\Repositories\pmas\admin\AdminPmasQuery;
use App\Repositories\pmas\user\UserPmasQuery;
use App\Services\CustomService;
use App\Services\user\ActionLogService;
use App\Services\user\UserService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    protected $conn;
    protected $customRepository;
    protected $customService;
    protected $userService;
    protected $actionLogService;
    protected $userPmasQuery;
    protected $adminPmasQuery;

    public function __construct(CustomRepository $customRepository, CustomService $customService, UserService $userService, UserPmasQuery $userPmasQuery, ActionLogService $actionLogService, AdminPmasQuery $adminPmasQuery)
    {

        $this->customRepository = $customRepository;
        $this->userPmasQuery = $userPmasQuery;
        $this->customService = $customService;
        $this->userService = $userService;
        $this->actionLogService = $actionLogService;
        $this->adminPmasQuery = $adminPmasQuery;
        $this->conn = config('custom_config.database.pmas');

    }

    public function filter_true_transactions($filter_data)
    {
        $data = [];
        $items = $this->adminPmasQuery->QueryPendingTransactionsDateFilter($filter_data);
        foreach ($items as $row) {
            $action = '';
            $status_display = '';

            if ($row->remarks == '' and $row->action_taken_date == null) {

                $action = '<div class="btn-group dropleft">
                                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                         <i class="ti-settings" style="font-size : 15px;"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                          <a class="dropdown-item" href="javascript:;" data-id="' . $row->transaction_id . '" id="add-remarks">Add Remarks</a>
                                          <hr>
                                          <a class="dropdown-item" href="javascript:;" data-id="' . $row->transaction_id . '" data-status="' . $row->transaction_status . '"  id="view_transaction">View Information</a>
                                           <hr>
                                          <a class="dropdown-item completed" href="javascript:;" data-id="' . $row->transaction_id . '" data-status="' . $row->transaction_status . '"  >Approve</a>
                                        </di>';
                $status_display = '<a href="javascript:;" class="btn btn-danger btn-rounded p-1 pl-2 pr-2">no remarks</a>';
            } else if ($row->remarks != '' and $row->action_taken_date == null) {

                $action = '<div class="btn-group dropleft">
                                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                         <i class="ti-settings" style="font-size : 15px;"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                         
                                          <a class="dropdown-item" href="javascript:;" data-id="' . $row->transaction_id . '" data-status="' . $row->transaction_status . '"  id="view_transaction_pending">View Information</a>
                                        </di>';
                $status_display = '<a href="javascript:;" class="btn btn-success btn-rounded p-1 pl-2 pr-2">remarks added</a><br><a href="javascript:;" data-id="' . $row->transaction_id . '"  id="update-remark" >Update</a>';

            } else if ($row->remarks != '' and $row->action_taken_date != null) {

                $action = '<a href="javascript:;"  data-id="' . $row->transaction_id . '" class="btn sub-button btn-rounded p-1 pl-2 pr-2 completed mr-2"><i class="ti-check"></i></a> <a href="javascript:;"  data-id="' . $row->transaction_id . '" class="btn btn-secondary btn-rounded p-1 pl-2 pr-2" id="view_transaction" ><i class="ti-eye"></i></a>';
                $status_display = '<a href="javascript:;" class="btn btn-success btn-rounded p-1 pl-2 pr-2">Accomplished</a><br><a href="javascript:;" >' . date('F d Y', strtotime($row->action_taken_date)) . '</a>';

            }


            $data[] = array(
                'transaction_id' => $row->transaction_id,
                'pmas_no' => date('Y', strtotime($row->date_and_time_filed)) . ' - ' . date('m', strtotime($row->date_and_time_filed)) . ' - ' . $row->number,
                'date_and_time_filed' => date('F d Y', strtotime($row->date_and_time_filed)) . ' ' . date('h:i a', strtotime($row->date_and_time_filed)),
                'responsible_section' => $row->responsible_section_name,
                'type_of_activity_name' => $row->type_of_activity_name,
                'responsibility_center' => $row->responsibility_center_code . ' - ' . $row->responsibility_center_name,
                'date_and_time' => date('F d Y', strtotime($row->date_and_time)) . ' ' . date('h:i a', strtotime($row->date_and_time)),
                'is_training' => $row->is_training == 1 ? true : false,
                'is_project_monitoring' => $row->is_project_monitoring == 1 ? true : false,
                'name' => $row->first_name . ' ' . $row->middle_name . ' ' . $row->last_name . ' ' . $row->extension,
                'cso_name' => $row->cso_id == 0 ? ' - ' : $row->cso_name,
                's' => $status_display,
                'action' => $action,
            );

        }

        return $data;
    }

    public function filter_false_transactions()
    {
        $data = [];
        $items = $this->adminPmasQuery->QueryPendingTransactions();
        foreach ($items as $row) {
            $action = '';
            $status_display = '';
            $update_status = '';
            if ($row->remarks == '' and $row->action_taken_date == null) {
                if ($row->update_status == 'updated') {
                    $update_status = '<a href="javascript:;" class="btn btn-success btn-rounded p-1 pl-2 pr-2">Updated</a>';
                } else {
                    $update_status = '';
                }
                $action = '<div class="btn-group dropleft">
                                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ti-settings" style="font-size : 15px;"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="javascript:;" data-id="' . $row->transaction_id . '" id="add-remarks">Add Remarks</a>
                                    <hr>
                                    <a class="dropdown-item" href="javascript:;" data-id="' . $row->transaction_id . '" data-status="' . $row->transaction_status . '"  id="view_transaction">View Information</a>
                                    <hr>
                                    <a class="dropdown-item completed" href="javascript:;" data-id="' . $row->transaction_id . '" data-status="' . $row->transaction_status . '"  >Approve</a>
                                </di>';
                $status_display = '<a href="javascript:;" class="btn btn-danger btn-rounded p-1 pl-2 pr-2">no remarks</a> ' . $update_status;
            } else if ($row->remarks != '' and $row->action_taken_date == null) {
                $action = '<div class="btn-group dropleft">
                                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ti-settings" style="font-size : 15px;"></i>
                                </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:;" data-id="' . $row->transaction_id . '" data-status="' . $row->transaction_status . '"  id="view_transaction">View Information</a>
                            </di>';
                $status_display = '<a href="javascript:;" class="btn btn-success btn-rounded p-1 pl-2 pr-2">remarks added</a><br>';
            } else if ($row->remarks != '' and $row->action_taken_date != null) {
                $action = '<a href="javascript:;"  data-id="' . $row->transaction_id . '" class="btn sub-button btn-rounded p-1 pl-2 pr-2 completed mr-2"><i class="ti-check"></i></a><a href="javascript:;"  data-id="' . $row->transaction_id . '" class="btn btn-secondary btn-rounded p-1 pl-2 pr-2" id="view_transaction" ><i class="ti-eye"></i></a>';
                $status_display = '<a href="javascript:;" class="btn btn-success btn-rounded p-1 pl-2 pr-2">Accomplished </a><br><a href="javascript:;" >' . date('F d Y', strtotime($row->action_taken_date)) . '</a>';
            }
            $data[] = array(
                'transaction_id' => $row->transaction_id,
                'pmas_no' => date('Y', strtotime($row->date_and_time_filed)) . ' - ' . date('m', strtotime($row->date_and_time_filed)) . ' - ' . $row->number,
                'date_and_time_filed' => date('F d Y', strtotime($row->date_and_time_filed)) . ' ' . date('h:i a', strtotime($row->date_and_time_filed)),
                'responsible_section' => $row->responsible_section_name,
                'type_of_activity_name' => $row->type_of_activity_name,
                'responsibility_center' => $row->responsibility_center_code . ' - ' . $row->responsibility_center_name,
                'date_and_time' => date('F d Y', strtotime($row->date_and_time)) . ' ' . date('h:i a', strtotime($row->date_and_time)),
                'is_training' => $row->is_training == 1 ? true : false,
                'is_project_monitoring' => $row->is_project_monitoring == 1 ? true : false,
                'name' => $row->first_name . ' ' . $row->middle_name . ' ' . $row->last_name . ' ' . $row->extension,
                'cso_name' => $row->cso_id == 0 ? ' - ' : $row->cso_name,
                's' => $status_display,
                'action' => $action,
            );

        }

        return $data;

    }


    //Report

    public function first_report($filter_data)
    {
        $data = [];
        $items = $this->adminPmasQuery->QueryCompletedTransactionDateFilterWhere($filter_data);
        foreach ($items as $row) {
            $data[] = array(
                'transaction_id' => $row->transaction_id,
                'pmas_no' => $this->customService->pmas_number($row),
                'date_and_time_filed' => date('F d Y', strtotime($row->date_and_time_filed)) . ' ' . date('h:i a', strtotime($row->date_and_time_filed)),
                'type_of_activity_name' => strtolower($row->type_of_activity_name) == strtolower('Regular Monthly Project Monitoring') ? '<a href="javascript:;"    data-id="' . $row->transaction_id . '"  style="color: #000;"  >' . $row->type_of_activity_name . '</a>' : $row->type_of_activity_name,
                'cso_name' => strtolower($row->type_of_activity_name) == strtolower('Regular Monthly Project Monitoring') ? '<a href="javascript:;" data-title="' . $row->cso_name . '" id="view_project_monitoring"    data-id="' . $row->transaction_id . '" style="color: #000; font-weight: bold;"  >' . $row->cso_name . '</a>' : $row->cso_name,
                'name' => $this->userService->user_full_name($row),
                'total_volume_of_business' => number_format($this->adminPmasQuery->QueryProjectMonitoringWhereSUM('total_collection_sales', array('project_transact_id' => $row->transaction_id)) + $this->adminPmasQuery->QueryProjectMonitoringWhereSUM('total_released_purchases', array('project_transact_id' => $row->transaction_id)), 2, '.', ','),
                'total_cash_position' => number_format($this->adminPmasQuery->QueryProjectMonitoringWhereSUM('cash_in_bank', array('project_transact_id' => $row->transaction_id)) + $this->adminPmasQuery->QueryProjectMonitoringWhereSUM('cash_on_hand', array('project_transact_id' => $row->transaction_id)) + $this->adminPmasQuery->QueryProjectMonitoringWhereSUM('inventories', array('project_transact_id' => $row->transaction_id)), 2, '.', ',')

            );

        }

        return $data;
    }


    public function second_report($filter_data)
    {
        $data = [];
        $items = $this->adminPmasQuery->QueryCompletedTransactionDateFilterWhereCSO($filter_data);
        foreach ($items as $row) {
            $data[] = array(
                'transaction_id' => $row->transaction_id,
                'pmas_no' => $this->customService->pmas_number($row),
                'date_and_time_filed' => date('F d Y', strtotime($row->date_and_time_filed)) . ' ' . date('h:i a', strtotime($row->date_and_time_filed)),
                'type_of_activity_name' => strtolower($row->type_of_activity_name) == strtolower('Regular Monthly Project Monitoring') ? '<a href="javascript:;"    data-id="' . $row->transaction_id . '"  style="color: #000;"  >' . $row->type_of_activity_name . '</a>' : $row->type_of_activity_name,
                'cso_name' => strtolower($row->type_of_activity_name) == strtolower('Regular Monthly Project Monitoring') ? '<a href="javascript:;" data-title="' . $row->cso_name . '" id="view_project_monitoring"    data-id="' . $row->transaction_id . '" style="color: #000; font-weight: bold;"  >' . $row->cso_name . '</a>' : $row->cso_name,
                'name' => $this->userService->user_full_name($row),
                'total_volume_of_business' => number_format($this->adminPmasQuery->QueryProjectMonitoringWhereSUM('total_collection_sales', array('project_transact_id' => $row->transaction_id)) + $this->adminPmasQuery->QueryProjectMonitoringWhereSUM('total_released_purchases', array('project_transact_id' => $row->transaction_id)), 2, '.', ','),
                'total_cash_position' => number_format($this->adminPmasQuery->QueryProjectMonitoringWhereSUM('cash_in_bank', array('project_transact_id' => $row->transaction_id)) + $this->adminPmasQuery->QueryProjectMonitoringWhereSUM('cash_on_hand', array('project_transact_id' => $row->transaction_id)) + $this->adminPmasQuery->QueryProjectMonitoringWhereSUM('inventories', array('project_transact_id' => $row->transaction_id)), 2, '.', ',')

            );

        }

        return $data;
    }

    public function third_report($filter_data)
    {
        $data = [];
        $items = $this->adminPmasQuery->QueryCompletedTransactionDateFilter($filter_data);
        foreach ($items as $row) {
            $data[] = array(
                'transaction_id' => $row->transaction_id,
                'pmas_no' => $this->customService->pmas_number($row),
                'date_and_time_filed' => date('F d Y', strtotime($row->date_and_time_filed)) . ' ' . date('h:i a', strtotime($row->date_and_time_filed)),
                'type_of_activity_name' => strtolower($row->type_of_activity_name) == strtolower('Regular Monthly Project Monitoring') ? '<a href="javascript:;"    data-id="' . $row->transaction_id . '"  style="color: #000;"  >' . $row->type_of_activity_name . '</a>' : $row->type_of_activity_name,
                'cso_name' => strtolower($row->type_of_activity_name) == strtolower('Regular Monthly Project Monitoring') ? '<a href="javascript:;" data-title="' . $row->cso_name . '" id="view_project_monitoring"    data-id="' . $row->transaction_id . '" style="color: #000; font-weight: bold;"  >' . $row->cso_name . '</a>' : $row->cso_name,
                'name' => $this->userService->user_full_name($row),
            );

        }

        return $data;


    }


}
