<?php

namespace App\Http\Controllers\systems\watchlisted\both;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Repositories\watchlisted\PersonQuery;
use App\Services\watchlisted\user\DashboardService;
use App\Services\user\ActionLogService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ViewController extends Controller
{

    protected $conn;
    protected $customRepository;
    protected $dashboardService;
    protected $actionLogService;
    protected $personQuery;
    public function __construct(CustomRepository $customRepository, DashboardService $dashboardService, ActionLogService $actionLogService, PersonQuery $personQuery)
    {
        $this->conn                 = config('custom_config.database.dts');
        $this->customRepository     = $customRepository;
        $this->dashboardService     = $dashboardService;
        $this->actionLogService     = $actionLogService;
        $this->personQuery          = $personQuery;
    }

    public function get_watchlisted_records()
    {
        $data = [];
        $id         = $_GET['id'];
        $items      = $this->customRepository->q_get_where($this->conn, array('p_id' => $id), 'records')->get();
        $person     = $this->customRepository->q_get_where($this->conn, array('person_id' => $id), 'persons')->first();
        foreach ($items as $row) {

            $data[] = array(

                'created_at'            => date('M d Y - h:i a', strtotime($row->created_at)),
                'record_description'    => $row->record_description,
                'p_id'                  => $row->p_id,
                'record_id'             => $row->record_id,
                'actions'               => session('user_id') == $person->added_by ||  session('user_type') == 'admin'  ?  true : false


            );
        }
        return response()->json($data);
    }

    //Create

    public function insert_update_records(Request $request)
    {
        $items = array(
            'record_description'      => $request->input('record_description'),
        );
        if (empty($request->input('record_id'))) {
            $items["created_at"] = Carbon::now()->format('Y-m-d H:i:s');
            $items["p_id"] = $request->input('person_id');
            $insert = $this->customRepository->insert_item($this->conn, 'records', $items);
            if ($insert) {
                // Registration successful
                return response()->json([
                    'message' => 'Record Added Successfully',
                    'response' => true
                ], 201);
            } else {
                return response()->json([
                    'message' => 'Something Wrong',
                    'response' => false
                ], 422);
            }
        } else {

            $where = array('record_id' => $request->input('record_id'));
            $update = $this->customRepository->update_item($this->conn, 'records', $where, $items);
            if ($update) {
                // Registration successful
                return response()->json([
                    'message' => 'Records Updated Successfully',
                    'response' => true
                ], 201);
            } else {
                return response()->json([
                    'message' => 'Something Wrong',
                    'response' => false
                ], 422);
            }
        }
    }

    //DELETE

    public function delete_record(Request $request){
        $id = $request->input('id');
        $delete = $this->customRepository->delete_item($this->conn,'records', array('record_id' => $id));
        if ($delete) {
            $data = array('message' => 'Deleted Succesfully', 'response' => true );
        } else {
            $data = array('message' => 'Error', 'response' => false);
        }
        return response()->json($data);
    }
}
