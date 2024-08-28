<?php

namespace App\Http\Controllers\systems\watchlisted\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Repositories\watchlisted\PersonQuery;
use App\Services\user\ActionLogService;
use App\Services\user\UserService;
use App\Services\watchlisted\user\DashboardService;
use Carbon\Carbon;
class ViewController extends Controller
{

    protected $conn;
    protected $customRepository;
    protected $dashboardService;
    protected $actionLogService;
    protected $userService;
    protected $personQuery;
    public function __construct(CustomRepository $customRepository, DashboardService $dashboardService, PersonQuery $personQuery, UserService $userService, ActionLogService $actionLogService)
    {
        $this->conn = config('custom_config.database.dts');
        $this->customRepository = $customRepository;
        $this->dashboardService = $dashboardService;
        $this->actionLogService = $actionLogService;
        $this->userService = $userService;
        $this->personQuery = $personQuery;

    }
    public function index($id)
    {

        $count = $this->customRepository->q_get_where($this->conn, array('person_id' => $id), 'persons');
        if ($count->count() > 0) {
            $data['title'] = $this->userService->user_full_name($count->first());
            $data['person_data'] = $this->personQuery->QueryPersonData($id);
            $data['programs'] = $this->get_programs($id);
            $data['person_programs'] = $this->get_person_programs($data['programs']);
            $data['barangay'] = config('custom_config.barangay');
            return view('systems.watchlisted.admin.pages.view.view')->with($data);
        } else {
            echo '404';
        }
    }

    private function get_person_programs($data)
    {

        $item = [];

        foreach ($data as $row) {

            if ($row['x'] == true) {

                array_push($item, $row['program']);
            }
        }

        return $item;

    }




    private function get_programs($id)
    {
        $items = $this->customRepository->q_get_order($this->conn, 'programs', 'program', 'asc')->get();
        $data = [];
        foreach ($items as $row) {
            $program_id = $row->program_id;
            $x = $this->customRepository->q_get_where($this->conn, array('person_id' => $id, 'program_id' => $program_id), 'program_block')->count();
            $data[] = array(

                'program' => $row->program,
                'program_id' => $row->program_id,
                'x' => $x == 1 ? true : null
            );
        }


        return $data;


    }


    public function save_record_program(Request $request)
    {
        $ids = $request->input('id');
        $person_id = $request->input('person_id');

        if (is_array($ids)) {
            $this->customRepository->delete_item($this->conn, 'program_block', array('person_id' => $person_id));
            foreach ($ids as $row) {
                $item = array(

                    'person_id' => $person_id,
                    'program_id' => $row,
                    'created' => Carbon::now()->format('Y-m-d H:i:s'),
                );
                $add = $this->customRepository->insert_item($this->conn, 'program_block', $item);
            }
            $data = array('message' => 'Added Succesfully', 'response' => true);
        } else {
            $delete = $this->customRepository->delete_item($this->conn, 'program_block', array('person_id' => $person_id));
            if ($delete) {
                $data = array('message' => 'Programs Removed Succesfully', 'response' => true);
            } else {
                $data = array('message' => 'Server Error', 'response' => false);
            }
        }

        return response()->json($data);
    }

    public function update_information(Request $request){

        $items = array(

            'first_name'        => $request->input('firstName'),
            'middle_name'       => $request->input('middleName'),
            'last_name'         => $request->input('lastName'),
            'extension'         => $request->input('extension'),
            'phone_number'      => $request->input('phoneNumber'),
            'address'           => $request->input('address'),
            'email_address'     => $request->input('emailAddress'),
            'age'               => $request->input('age'),
            'gender'            => $request->input('gender')
        );

       
        $id = $request->input('person_id');
        $update = $this->customRepository->update_item($this->conn,'persons', array('person_id' => $id), $items);
        if ($update) {
            $user_row = $this->customRepository->q_get_where($this->conn,array('person_id' => $id),'persons')->first();
            $this->actionLogService->wl_add_action('Updated "' . $this->userService->user_full_name($user_row).'" information', session('user_type'), $user_row->person_id);
            $data = array('message' => 'Updated Successfully', 'response' => true);
        } else {
            $data = array('message' => 'Something Wrong/Data is not updated', 'response' => false);
        }
        return response()->json($data);
        
    }

}
