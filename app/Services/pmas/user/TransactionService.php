<?php

namespace App\Services\pmas\user;
use App\Repositories\CustomRepository;
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

    public function __construct(CustomRepository $customRepository, CustomService $customService, UserService $userService, UserPmasQuery $userPmasQuery, ActionLogService $actionLogService)
    {

        $this->customRepository = $customRepository;
        $this->userPmasQuery = $userPmasQuery;
        $this->customService = $customService;
        $this->userService = $userService;
        $this->actionLogService = $actionLogService;
        $this->conn = config('custom_config.database.pmas');

    }

    public function add_transaction_process($request)
    {


        $data = array(
            'number' => $request->input('pmas_number'),
            'date_and_time_filed' => Carbon::now()->format('Y-m-d H:i:s'),
            'responsible_section_id' => $request->input('type_of_monitoring_id'),
            'type_of_activity_id' => $request->input('type_of_activity_id'),
            'under_type_of_activity_id' => $request->input('select_under_type_id'),
            'date_and_time' => date("Y/m/d H:i:s", strtotime($request->input('date_time'))),
            'responsibility_center_id' => $request->input('responsibility_center_id'),
            'cso_Id' => $request->input('cso_id'),
            'created_by' => session('user_id'),
            'transaction_status' => 'pending',
            'update_status' => 'to-update'
        );

        $array_where = array(

            'date_and_time_filed' => date('Y-m', time()),
            'number' => $data['number']
        );

        $verify = $this->customRepository->q_get_where($this->conn, $array_where, 'transactions')->count();

        if (!$verify) {
            $id = DB::connection($this->conn)->table('transactions')->insertGetId($data);
            $type_act_name = $this->customRepository->q_get_where($this->conn, array('type_of_activity_id' => $data['type_of_activity_id']), 'type_of_activities')->first()->type_of_activity_name;

            $training_data = array(

                'training_transact_id' => $id,
                'title_of_training' => $request->input('title_of_training'),
                'number_of_participants' => $request->input('number_of_participants'),
                'female' => $request->input('female'),
                'overall_ratings' => $request->input('over_all_ratings'),
                'name_of_trainor' => $request->input('name_of_trainor'),
            );


            $project_data = array(

                'project_transact_id' => $id,
                'project_title' => $request->input('project_title'),
                'period' => date("Y/m/d", strtotime($request->input('period'))),
                'attendance_present' => $request->input('present'),
                'attendance_absent' => $request->input('absent'),
                'nom_borrowers_delinquent' => $request->input('deliquent'),
                'nom_borrowers_overdue' => $request->input('overdue'),
                'total_production' => $request->input('total_production'),
                'total_collection_sales' => $request->input('total_collection'),
                'total_released_purchases' => $request->input('total_released'),
                'total_delinquent_account' => $request->input('total_deliquent'),
                'total_over_due_account' => $request->input('total_overdue'),
                'cash_in_bank' => $request->input('cash_in_bank'),
                'cash_on_hand' => $request->input('cash_on_hand'),
                'inventories' => $request->input('inventories'),

            );

            $project_meeting = array(
                'meeting_transaction_id' => $id,
                'meeting_present' => $request->input('meeting_present'),
                'meeting_absent' => $request->input('meeting_absent'),
            );

            if (strtolower($type_act_name) == 'training') {

                $where = array('transaction_id' => $id);
                $data = array('is_training' => 1);
                $update_training = $this->customRepository->update_item($this->conn, 'transactions', $where, $data);
                if ($update_training) {
                    $add_training = $this->customRepository->insert_item($this->conn, 'trainings', $training_data);
                    if ($add_training) {

                        $resp = array(
                            'message' => 'Success',
                            'response' => true
                        );


                        // code...
                    } else {

                        $resp = array(
                            'message' => 'error add training',
                            'response' => false
                        );

                    }

                } else {

                    $resp = array(
                        'message' => 'Error Update',
                        'response' => false
                    );
                }

            } else if (strtolower($type_act_name) == 'regular monthly project monitoring') {

                $where = array('transaction_id' => $id);
                $data = array('is_project_monitoring' => 1);
                $update_project = $this->customRepository->update_item($this->conn, 'transactions', $where, $data);
                if ($update_project) {
                    $add_project = $this->customRepository->insert_item($this->conn, 'project_monitoring', $project_data);
                    if ($add_project) {

                        $resp = array(
                            'message' => 'Success',
                            'response' => true
                        );


                        // code...
                    } else {

                        $resp = array(
                            'message' => 'error add project',
                            'response' => false
                        );

                    }

                } else {

                    $resp = array(
                        'message' => 'Error Update',
                        'response' => false
                    );
                }

            } else if (strtolower($type_act_name) == 'regular monthly meeting') {


                $where = array('transaction_id' => $id);
                $data = array('is_project_meeting' => 1);
                $update_project_meeting = $this->customRepository->update_item($this->conn, 'transactions', $where, $data);

                if ($update_project_meeting) {

                    $add_project_meeting = $this->customRepository->insert_item($this->conn, 'project_meeting', $project_meeting);
                    if ($add_project_meeting) {

                        $resp = array(
                            'message' => 'Success',
                            'response' => true
                        );


                        // code...
                    } else {

                        $resp = array(

                            'message' => 'error add project',
                            'response' => false
                        );

                    }

                } else {

                    $resp = array(
                        'message' => 'Error Update',
                        'response' => false
                    );
                }

            }

            $item = $this->customRepository->q_get_where($this->conn, array('transaction_id' => $id), 'transactions')->first();
            $this->actionLogService->add_pmas_rfa_action('pmas', $id, 'Added PMAS No. ' . $this->customService->pmas_number($item));

            $resp = array(
                'message' => 'Successfully Added',
                'response' => true
            );

        } else {

            $resp = array(
                'message' => 'Error Duplicate PMAS NO',
                'response' => false
            );

        }

        return $resp;

    }




    public function transaction_data($id)
    {

        $row = $this->userPmasQuery->QueryTransactionData($id);

        $training_data = [];
        $project_data = [];
        $project_meeting_data = [];

        if ($row->is_training == 1) {

            $row_training = $this->customRepository->q_get_where($this->conn, array('training_transact_id' => $row->transaction_id), 'trainings')->first();
            $training_data[] = array(

                'title_of_training' => $row_training->title_of_training,
                'number_of_participants' => $row_training->number_of_participants,
                'female' => $row_training->female,
                'male' => $row_training->number_of_participants - $row_training->female,
                'overall_ratings' => $row_training->overall_ratings,
                'name_of_trainor' => $row_training->name_of_trainor


            );
        }

        if ($row->is_project_monitoring == 1) {

            $row_project = $this->customRepository->q_get_where($this->conn, array('project_transact_id' => $row->transaction_id), 'project_monitoring')->first();
            $project_data[] = array(

                'project_title' => $row_project->project_title,
                'period' => date("m/d/Y", strtotime($row_project->period)) == '01/01/1970' ? ' - ' : date("m/d/Y", strtotime($row_project->period)),
                'present' => $row_project->attendance_present,
                'absent' => $row_project->attendance_absent,

                'delinquent' => $row_project->nom_borrowers_delinquent,
                'overdue' => $row_project->nom_borrowers_overdue,
                'total_production' => $row_project->total_production,
                'total_collection_sales' => number_format($row_project->total_collection_sales, 2, '.', ','),
                'total_released_purchases' => number_format($row_project->total_released_purchases, 2, '.', ','),
                'total_delinquent_account' => number_format($row_project->total_delinquent_account, 2, '.', ','),
                'total_over_due_account' => number_format($row_project->total_over_due_account, 2, '.', ','),
                'cash_in_bank' => number_format($row_project->cash_in_bank, 2, '.', ','),
                'cash_on_hand' => number_format($row_project->cash_on_hand, 2, '.', ','),
                'inventories' => number_format($row_project->inventories, 2, '.', ','),
                'total_volume_of_business' => number_format(array_sum(array(

                    $row_project->total_collection_sales,
                    $row_project->total_released_purchases,

                )), 2, '.', ','),
                'total_cash_position' => number_format(array_sum(array(

                    $row_project->cash_in_bank,
                    $row_project->cash_on_hand,
                    $row_project->inventories

                )), 2, '.', ','),

            );
        }


        if ($row->is_project_meeting) {

            $row_project_meeting = $this->customRepository->q_get_where($this->conn, array('meeting_transaction_id' => $row->transaction_id), 'project_meeting')->first();

            $project_meeting_data[] = array(

                'meeting_present' => $row_project_meeting->meeting_present,
                'meeting_absent' => $row_project_meeting->meeting_absent
            );
            // code...
        }

        $data = array(

            'transaction_id' => $row->transaction_id,
            'number' => $row->number,
            'month' => date('m', strtotime($row->date_and_time_filed)),
            'year' => date('Y', strtotime($row->date_and_time_filed)),
            'responsible_section_id' => $row->responsible_section_id,
            'type_of_activity_id' => $row->type_of_activity_id,
            'under_type_activity' => $row->under_type_of_activity_id == 0 ? '' : $this->customRepository->q_get_where($this->conn, array('under_type_act_id' => $row->under_type_of_activity_id), 'under_type_of_activity')->first()->under_type_act_name,
            'responsibility_center_id' => $row->responsibility_center_id,
            'cso_id' => $row->cso_id,
            'cso_name' => $row->cso_Id == 0 ? ' - ' : $row->cso_name,
            'date_and_time' => date("m/d/Y h:i:s A", strtotime($row->date_and_time)),
            'under_type_of_activity' => $row->under_type_of_activity_id == 0 ? '' : $row->under_type_of_activity_id,


            'training_data' => $training_data,
            'project_monitoring_data' => $project_data,
            'project_meeting_data' => $project_meeting_data,


            //View Information
            'pmas_no' => date('Y', strtotime($row->date_and_time_filed)) . ' - ' . date('m', strtotime($row->date_and_time_filed)) . ' - ' . $row->number,
            'date_and_time_filed' => date('F d Y', strtotime($row->date_and_time_filed)) . ' ' . date('h:i a', strtotime($row->date_and_time_filed)),
            'responsible_section_name' => $row->responsible_section_name,
            'type_of_activity_name' => $row->type_of_activity_name,
            'responsibility_center_name' => $row->responsibility_center_name,
            'date_time' => date('F d, Y -  h:i A ', strtotime($row->date_and_time)),
            'annotations' => $row->annotations == NULL ? ' ' : $row->annotations,
            'annotation_text' => $row->annotations,
            'last_updated' => $row->updated_on == '0000-00-00 00:00:00' ? '<span class="text-danger">Not Updated</span>' : date('F d Y', strtotime($row->updated_on)) . ' ' . date('h:i a', strtotime($row->updated_on)),
            'remarks' => $row->remarks == '' ? 'No Remarks' : $row->remarks,
            'status_display' => $row->transaction_status == 'pending' ? '<a href="javascript:;" class="btn btn-danger btn-rounded   pull-left">Pending</a>' : '<a href="javascript:;" class="btn btn-success btn-rounded   pull-left">Completed</a>',
            'date_approved' => $row->transaction_date_time_completed == NULL ? '' : date("m/d/Y h:i:s A", strtotime($row->transaction_date_time_completed)),
            'person_responsible' => $row->first_name . ' ' . $row->middle_name . ' ' . $row->last_name . ' ' . $row->extension,

        );
        return $data;

    }


    public function update_process($request)
    {
        $where = array('transaction_id' => $request->input('transaction_id'));
        $add_project_data = [];
        $data = array(
            
            'responsible_section_id'                => $request->input('type_of_monitoring_id'),
            'type_of_activity_id'                   => $request->input('type_of_activity_id'),
            'under_type_of_activity_id'             => $request->input('select_under_type_id'),
            'date_and_time'                         => date("Y/m/d H:i:s", strtotime($request->input('update_date_and_time'))),
            'responsibility_center_id'              => $request->input('responsibility_center_id'),
            'cso_Id'                                => $request->input('cso_id'),
            'annotations'                           => $request->input('annotation'),
            'updated_on'                            => Carbon::now()->format('Y-m-d H:i:s'),
            'update_status'                         => 'updated'
        );
        $result = $this->customRepository->update_item($this->conn, 'transactions', $where, $data);
        if ($result) {
            $type_act_name = $this->customRepository->q_get_where($this->conn, array('type_of_activity_id' => $data['type_of_activity_id']), 'type_of_activities')->first()->type_of_activity_name;
            $training_data = array(

                'title_of_training'                 => $request->input('title_of_training'),
                'number_of_participants'            => $request->input('number_of_participants'),
                'female'                            => $request->input('female'),
                'overall_ratings'                   => $request->input('over_all_ratings'),
                'name_of_trainor'                   => $request->input('name_of_trainor'),
            );



            $project_data = array(
                'project_title'                     => $request->input('update_project_title'),
                'period'                            => date("Y/m/d", strtotime($request->input('update_period'))),
                'attendance_present'                => $request->input('present'),
                'attendance_absent'                 => $request->input('absent'),
                'nom_borrowers_delinquent'          => $request->input('deliquent'),
                'nom_borrowers_overdue'             => $request->input('overdue'),
                'total_production'                  => $request->input('total_production'),
                'total_collection_sales'            => $request->input('total_collection'),
                'total_released_purchases'          => $request->input('total_released'),
                'total_delinquent_account'          => $request->input('total_deliquent'),
                'total_over_due_account'            => $request->input('total_overdue'),
                'cash_in_bank'                      => $request->input('cash_in_bank'),
                'cash_on_hand'                      => $request->input('cash_on_hand'),
                'inventories'                       => $request->input('inventories'),

            );
            $where2 = array('training_transact_id'  => $where['transaction_id']);
            $where3 = array('project_transact_id'   => $where['transaction_id']);
            $where4 = array('meeting_transaction_id'=> $where['transaction_id']);
            if (strtolower($type_act_name) == 'training') {

                $add_training_data = array(
                    'training_transact_id'          => $where['transaction_id'],
                    'title_of_training'             => $request->input('title_of_training'),
                    'number_of_participants'        => $request->input('number_of_participants'),
                    'female'                        => $request->input('female'),
                    'overall_ratings'               => $request->input('over_all_ratings'),
                    'name_of_trainor'               => $request->input('name_of_trainor'),
                );

                $is_training_data = array('is_training' => 1, 'is_project_monitoring' => 0, 'is_project_meeting' => 0);
                $update_is_training = $this->customRepository->update_item($this->conn, 'transactions', $where, $is_training_data);


                if ($update_is_training) {

                    $count_training = $this->customRepository->q_get_where($this->conn, $where2, 'trainings')->count();
                    if ($count_training > 0) {

                        $update_training = $this->customRepository->update_item($this->conn, 'trainings', $where2, $training_data);


                        if ($update_training) {

                            $resp = array(
                                'message' => 'Success Updated',
                                'response' => true
                            );

                        } else {

                            $resp = array(
                                'message' => 'error Update training',
                                'response' => false
                            );
                        }


                    } else {

                        $add_training = $this->customRepository->insert_item($this->conn, 'trainings', $add_training_data);
                        if ($add_training) {

                            $resp = array(
                                'message' => 'Success',
                                'response' => true
                            );
                            // code...
                        } else {

                            $resp = array(
                                'message' => 'error add training',
                                'response' => false
                            );

                        }
                    }

                } else {

                    $resp = array(
                        'message' => 'Error Update',
                        'response' => false
                    );


                }




            } else if (strtolower($type_act_name) == 'regular monthly project monitoring') {


                $add_project_data = array(

                    'project_transact_id'               => $where['transaction_id'],
                    'project_title'                     => $request->input('project_title'),
                    'period'                            => date("Y/m/d", strtotime($request->input('period'))),
                    'attendance_present'                => $request->input('present'),
                    'attendance_absent'                 => $request->input('absent'),
                    'nom_borrowers_delinquent'          => $request->input('deliquent'),
                    'nom_borrowers_overdue'             => $request->input('overdue'),
                    'total_production'                  => $request->input('total_production'),
                    'total_collection_sales'            => $request->input('total_collection'),
                    'total_released_purchases'          => $request->input('total_released'),
                    'total_delinquent_account'          => $request->input('total_deliquent'),
                    'total_over_due_account'            => $request->input('total_overdue'),
                    'cash_in_bank'                      => $request->input('cash_in_bank'),
                    'cash_on_hand'                      => $request->input('cash_on_hand'),
                    'inventories'                       => $request->input('inventories'),

                );

                $is_project_data = array('is_project_monitoring' => 1, 'is_training' => 0, 'is_project_meeting' => 0);
                $update_project = $this->customRepository->update_item($this->conn, 'transactions', $where, $is_project_data);
                if ($update_project) {
                    $count_project = $this->customRepository->q_get_where($this->conn, $where3, 'project_monitoring')->count();
                    if ($count_project > 0) {
                        $update_project = $this->customRepository->update_item($this->conn, 'project_monitoring', $where3, $project_data);
                        if ($update_project) {

                            $resp = array(
                                'message' => 'Success Updated',
                                'response' => true
                            );

                        } else {

                            $resp = array(
                                'message' => 'error Update training',
                                'response' => false
                            );
                        }


                    } else {
                        $add_project = $this->customRepository->insert_item($this->conn, 'project_monitoring', $add_project_data);
                        if ($add_project) {
                            $resp = array(
                                'message' => 'Success',
                                'response' => true
                            );
                        } else {

                            $resp = array(
                                'message' => 'error add training',
                                'response' => false
                            );

                        }

                    }

                } else {

                    $resp = array(
                        'message' => 'Error Update',
                        'response' => false
                    );

                }



            } else if (strtolower($type_act_name) == 'regular monthly meeting') {

                $is_meeting_data = array('is_training' => 0, 'is_project_monitoring' => 0, 'is_project_meeting' => 1);

                $add_project_meeting_data = array(
                    'meeting_transaction_id'        => $where['transaction_id'],
                    'meeting_present'               => $request->input('meeting_present'),
                    'meeting_absent'                => $request->input('meeting_absent'),
                );
                $update_project = $this->customRepository->update_item($this->conn, 'transactions', $where, $is_meeting_data);
                if ($update_project) {
                    $count_project = $this->customRepository->q_get_where($this->conn, $where4, 'project_meeting')->count();
                    if ($count_project > 0) {
                        $update_project = $this->customRepository->update_item($this->conn, 'project_meeting', $where4, $add_project_meeting_data);
                        if ($update_project) {

                            $resp = array(
                                'message' => 'Success Updated',
                                'response' => true
                            );

                        } else {

                            $resp = array(
                                'message' => 'error Update training',
                                'response' => false
                            );
                        }
                    } else {
                        $add_project = $this->customRepository->insert_item($this->conn, 'project_meeting', $add_project_meeting_data);
                        if ($add_project) {

                            $resp = array(
                                'message' => 'Success',
                                'response' => true
                            );
                            // code...
                        } else {

                            $resp = array(
                                'message' => 'error add training',
                                'response' => false
                            );

                        }
                    }
                    //end

                } else {

                    $resp = array(
                        'message' => 'Error Update',
                        'response' => false
                    );

                }
            } else {
                $this->customRepository->delete_item($this->conn, 'trainings', $where2);
                $this->customRepository->delete_item($this->conn, 'project_monitoring', $where3);
                $this->customRepository->delete_item($this->conn, 'project_meeting', $where4);
                $data_update_2 = array('is_training' => 0, 'is_project_monitoring' => 0, 'is_project_meeting' => 0);
                $this->customRepository->update_item($this->conn, 'transactions', $where, $data_update_2);
            }

            $item = $this->customRepository->q_get_where($this->conn, array('transaction_id' => $where['transaction_id']), 'transactions')->first();
            $this->actionLogService->add_pmas_rfa_action('pmas', $item->transaction_id, 'Updated PMAS No. ' . $this->customService->pmas_number($item));
            $resp = array(
                'message' => 'Successfully Updated',
                'response' => true
            );
        } else {
            $resp = array(
                'message' => 'Error Update',
                'response' => false
            );

        }

        return $resp;

    }


}
