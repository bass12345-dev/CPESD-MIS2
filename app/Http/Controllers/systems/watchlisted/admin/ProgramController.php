<?php

namespace App\Http\Controllers\systems\watchlisted\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Repositories\watchlisted\PersonQuery;
use App\Services\watchlisted\user\DashboardService;
use Carbon\Carbon;
class ProgramController extends Controller
{

    protected $conn;
    protected $customRepository;
    protected $dashboardService;
    protected $personQuery;
    public function __construct(CustomRepository $customRepository, DashboardService $dashboardService, PersonQuery $personQuery)
    {
        $this->conn = config('custom_config.database.dts');
        $this->customRepository = $customRepository;
        $this->dashboardService = $dashboardService;
        $this->personQuery = $personQuery;

    }
    public function index()
    {
        $data['title'] = 'Manage Program';
        return view('systems.watchlisted.admin.pages.manage_program.manage_program')->with($data);
    }

    public function get_programs(){
        $items = $this->customRepository->q_get_order($this->conn,'programs', 'program', 'asc')->get();
        return response()->json($items);
    }

    public function insert_update_program(Request $request)
    {

        $items = array(
            'program'       => $request->input('program'),
            'program_description' => $request->input('program_description'),
        );
        if (empty($request->input('id'))) {
            $items["created"] = Carbon::now()->format('Y-m-d H:i:s');
            $insert = $this->customRepository->insert_item($this->conn, 'programs', $items);
            if ($insert) {
                // Registration successful
                return response()->json([
                    'message' => 'Program Added Successfully',
                    'response' => true
                ], 201);
            } else {
                return response()->json([
                    'message' => 'Something Wrong',
                    'response' => false
                ], 422);
            }
        } else {

            $where = array('program_id' => $request->input('id'));
            $update = $this->customRepository->update_item($this->conn, 'programs', $where, $items);
            if ($update) {
                // Registration successful
                return response()->json([
                    'message' => 'Program Updated Successfully',
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


    public function delete_program(Request $request)
    {
        $id = $request->input('id');
        $check = $this->customRepository->q_get_where($this->conn, array('program_id' => $id),'program_block')->count();

        if ($check > 0) {
            $data = array('message' => 'You cannot remove this data', 'response' => false);
        } else {
            $delete = $this->customRepository->delete_item($this->conn,'programs', array('program_id' => $id));
            if ($delete) {
                $data = array('message' => 'Deleted Succesfully', 'response' => true);
            } else {
                $data = array('message' => 'Server Error', 'response' => false);
            }
        }

        return response()->json($data);
    }

}
