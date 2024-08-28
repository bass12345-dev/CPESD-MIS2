<?php

namespace App\Http\Controllers\systems\cso;

use App\Http\Controllers\Controller;
use App\Repositories\cso\CSOQuery;
use App\Repositories\CustomRepository;
use App\Repositories\pmas\user\UserPmasQuery;
use App\Services\CustomService;
use App\Services\cso\CsoService;
use App\Services\user\ActionLogService;
use App\Services\user\UserService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ManageCsoController extends Controller
{

    protected $conn;
    protected $customRepository;
    protected $customService;
    protected $userService;
    protected $csoService;
    protected $userPmasQuery;
    protected $cSOQuery;
    protected $actionLogService;
    public function __construct(CustomRepository $customRepository, CustomService $customService, UserService $userService, UserPmasQuery $userPmasQuery, CsoService $csoService, ActionLogService $actionLogService, CSOQuery $cSOQuery)
    {

        $this->customRepository = $customRepository;
        $this->userPmasQuery = $userPmasQuery;
        $this->customService = $customService;
        $this->userService = $userService;
        $this->csoService = $csoService;
        $this->actionLogService = $actionLogService;
        $this->cSOQuery = $cSOQuery;
        $this->conn = config('custom_config.database.pmas');
    }
    public function index()
    {
        $data['title'] = 'Manage CSO';
        $data['type_of_cso'] = config('custom_config.cso_type');
        $data['barangay'] = config('custom_config.barangay');
        $data['positions'] = config('custom_config.positions');
        return view('systems.cso.pages.manage_cso.manage_cso')->with($data);
    }

    public function view_cso($id)
    {
        $row = $this->customRepository->q_get_where($this->conn, array('cso_id' => $id), 'cso');
        if ($row->count()) {
            $row = $row->first();
            $data['title'] = $row->cso_name;
            $data['row'] = $row;
            $data['type_of_cso'] = config('custom_config.cso_type');
            $data['barangay'] = config('custom_config.barangay');
            $a = [];
            $i = 1;
            foreach (config('custom_config.positions') as $row) {
                $a[] = array('position' => $row, 'number' => $i++);
            }
            $data['positions'] = $a;
            return view('systems.cso.pages.view_cso.view_cso')->with($data);
        } else {
            echo '404';
        }
    }

    //CSO
    //CREATE
    public function add_cso(Request $request)
    {

        $data = array(
            'cso_name' => $request->input('cso_name'),
            'cso_code' => $request->input('cso_code'),
            'type_of_cso' => strtoupper($request->input('cso_type')),
            'purok_number' => $request->input('purok'),
            'barangay' => $request->input('barangay'),
            'contact_person' => ($request->input('contact_person') == '') ? '' : $request->input('contact_person'),
            'contact_number' => $request->input('contact_number'),
            'telephone_number' => ($request->input('telephone_number') == '') ? '' : $request->input('telephone_number'),
            'email_address' => ($request->input('email_address') == '') ? '' : $request->input('email_address'),
            'cso_status' => 'active',
            'cso_created' => Carbon::now()->format('Y-m-d H:i:s'),

        );

        $verify = $this->customRepository->q_get_where($this->conn, array('cso_code' => $data['cso_code']), 'cso')->count();
        if ($verify > 0) {

            $data = array(
                'message' => 'Error Duplicate Code',
                'response' => false
            );
        } else {

            $cso_id = DB::connection($this->conn)->table('cso')->insertGetId($data);
            if ($cso_id) {
                $this->actionLogService->add_pmas_rfa_action('cso', $cso_id, 'Added CSO | ' . $data['cso_name']);
                $data = array(
                    'message' => 'CSO Added Succesfully',
                    'response' => true
                );
            } else {
                $data = array(
                    'message' => 'Something Wrong',
                    'response' => false
                );
            }
        }

        return response()->json($data);
    }
    //READ
    public function get_cso(Request $request)
    {
        $data = '';
        $where = array('cso_status' => $request->input('cso_status'), 'type_of_cso' => $request->input('cso_type'));
        if ($where['cso_status'] != '' && $where['type_of_cso'] == '') {
            $where_status = array('cso_status' => $where['cso_status']);
            $data = $this->csoService->cso_query_where($where_status);
        } else if ($where['type_of_cso'] != '' && $where['cso_status'] == '') {
            $where_status = array('type_of_cso' => $where['type_of_cso']);
            $data = $this->csoService->cso_query_where($where_status);
        } else if ($where['cso_status'] != '' && $where['type_of_cso'] != '') {
            $where_status = array('cso_status' => $where['cso_status'], 'type_of_cso' => $where['type_of_cso']);
            $data = $this->csoService->cso_query_where($where_status);
        } else if ($where['cso_status'] == '' && $where['type_of_cso'] == '') {
            $data = $this->csoService->all_cso();
        }

        return response()->json($data);
    }

    public function get_cso_infomation(Request $request)
    {

        $row = $this->customRepository->q_get_where($this->conn, array('cso_id' => $request->input('id')), 'cso')->first();

        $address = '';
        if ($row->barangay == '') {
            $address = '';
        } else if ($row->purok_number == '' && $row->barangay != '') {
            $address = $row->barangay;
        } else if ($row->purok_number != '' && $row->barangay != '') {
            $address = 'Purok ' . $row->purok_number . ' ' . $row->barangay;
        }
        $data = array(
            'cso_id' => $row->cso_id,
            'cso_name' => $row->cso_name,
            'cso_code' => $row->cso_code,
            'purok_number' => $row->purok_number,
            'barangay' => $row->barangay,
            'address' => $address,
            'contact_person' => $row->contact_person,
            'contact_number' => $row->contact_number,
            'telephone_number' => $row->telephone_number,
            'email_address' => $row->email_address,
            'type_of_cso' => strtoupper($row->type_of_cso),
            'status' => $row->cso_status,
            'cso_status' => $row->cso_status == 'active' ? '<span class="status-p bg-success">' . ucfirst($row->cso_status) . '</span>' : '<span class="status-p bg-danger">' . ucfirst($row->cso_status) . '</span>',



        );

        return response()->json($data);
    }
    //UPDATE
    public function update_cso_status(Request $request)
    {
        $data = array(
            'cso_status' => $request->input('cso_status_update')
        );

        $where = array(
            'cso_id' => $request->input('cso_id')
        );

        $update = $this->customRepository->update_item($this->conn, 'cso', $where, $data);
        if ($update) {
            $cso = $this->customRepository->q_get_where($this->conn, array('cso_id' => $where['cso_id']), 'cso')->first();
            $this->actionLogService->add_pmas_rfa_action('cso', $cso->cso_id, 'Updated CSO Status | ' . $cso->cso_name);
            $resp = array(
                'message' => 'Successfully Updated',
                'response' => true
            );
        } else {

            $resp = array(
                'message' => 'Error',
                'response' => false
            );
        }
        return response()->json($resp);
    }

    //DELETE

    public function update_cso_information(Request $request)
    {

        $data = array(
            'cso_name' => $request->input('cso_name'),
            'cso_code' => $request->input('cso_code'),
            'type_of_cso' => $request->input('cso_type'),
            'purok_number' => $request->input('purok'),
            'barangay' => $request->input('barangay'),
            'contact_person' => ($request->input('contact_person') == '') ? '' : $request->input('contact_person'),
            'contact_number' => $request->input('contact_number'),
            'telephone_number' => ($request->input('telephone_number') == '') ? '' : $request->input('telephone_number'),
            'email_address' => ($request->input('email_address') == '') ? '' : $request->input('email_address'),
        );

        $where = array(
            'cso_id' => $request->input('cso_idd')
        );

        $update = $this->customRepository->update_item($this->conn, 'cso', $where, $data);

        if ($update) {
            $cso = $this->customRepository->q_get_where($this->conn, array('cso_id' => $where['cso_id']), 'cso')->first();
            $this->actionLogService->add_pmas_rfa_action('cso', $cso->cso_id, 'Updated CSO Information | ' . $cso->cso_name);
            $resp = array(
                'message' => 'Successfully Updated',
                'response' => true
            );
        } else {

            $resp = array(
                'message' => 'Error',
                'response' => false
            );
        }
        return response()->json($resp);
    }
    public function delete_cso(Request $request)
    {
        $where1 = array('cso_Id' => $request->input('id'));
        $where2 = array('cso_id' => $request->input('id'));
        $check = $this->customRepository->q_get_where($this->conn, $where1, 'transactions')->count();
        $cso = $this->customRepository->q_get_where($this->conn, array('cso_id' => $where2['cso_id']), 'cso')->first();

        if ($check > 0) {
            $data = array(
                'message' => 'This CSO is used in other operations',
                'response' => false
            );
        } else {

            $result = $this->customRepository->delete_item($this->conn, 'cso', $where2);
            if ($result) {
                $this->actionLogService->add_pmas_rfa_action('cso', $cso->cso_id, 'Deleted CSO | ' . $cso->cso_name);
                $data = array(
                    'message' => 'CSO Added Succesfully',
                    'response' => true
                );
            } else {
                $data = array(
                    'message' => 'Something Wrong',
                    'response' => false
                );
            }
        }

        return response()->json($data);
    }

    //CSO OFFICERS
    //CREATE
    public function add_officer(Request $request)
    {
        $data = array(
            'officer_cso_id' => $request->input('cso_id'),
            'position_number' => explode("-", $request->input('cso_position'))[1],
            'first_name' => $request->input('first_name'),
            'middle_name' => ($request->input('middle_name') == '') ? '' : $request->input('middle_name'),
            'last_name' => $request->input('last_name'),
            'extension' => ($request->input('extension') == '') ? '' : $request->input('extension'),
            'cso_position' => $request->input('cso_position'),
            'contact_number' => $request->input('officer_contact_number'),
            'email_address' => $request->input('email'),
            'cso_officer_created' => Carbon::now()->format('Y-m-d H:i:s'),
        );

        $verify = $this->customRepository->q_get_where($this->conn, array('cso_position' => $data['cso_position'], 'position_number' => $data['position_number'], 'officer_cso_id' => $data['officer_cso_id']), 'cso_officers')->count();

        if ($verify > 0) {

            $data = array(
                'message' => 'Position is already taken',
                'response' => false
            );

        } else {
            $result = $this->customRepository->insert_item($this->conn, 'cso_officers', $data);
            if ($result) {
                $cso = $this->customRepository->q_get_where($this->conn, array('cso_id' => $data['officer_cso_id']), 'cso')->first();
                $this->actionLogService->add_pmas_rfa_action('cso', $cso->cso_id, 'Added ' . $data['first_name'] . ' ' . $data['middle_name'] . ' ' . $data['last_name'] . ' ' . $data['extension'] . ' as ' . $data['cso_position'] . ' of ' . $cso->cso_name);
                $data = array(
                    'message' => 'Added Succesfully',
                    'response' => true
                );
            } else {
                $data = array(
                    'message' => 'Something Wrong',
                    'response' => false
                );
            }


        }
        return response()->json($data);
    }
    //READ
    public function get_officers(Request $request)
    {
        $data = [];
        $pid = 0;
        $id = 1;
        $item = $this->customRepository->q_get_where_order($this->conn, 'cso_officers', array('officer_cso_id' => $request->input('cso_id')), 'position_number', 'asc')->get();
        foreach ($item as $row) {

            $data[] = array(
                'id' => $id++,
                'pid' => $pid++,
                'name' => $row->first_name . ' ' . $row->middle_name . ' ' . $row->last_name . ' ' . $row->extension,
                'first_name' => $row->first_name,
                'middle_name' => $row->middle_name,
                'last_name' => $row->last_name,
                'extension' => $row->extension,
                'title' => explode("-", $row->cso_position)[0],
                'position' => $row->cso_position,
                'img' => "https://www.pngitem.com/pimgs/m/504-5040528_empty-profile-picture-png-transparent-png.png",
                'contact_number' => $row->contact_number,
                'email_address' => $row->email_address,
                'cso_officer_id' => $row->cso_officer_id,




            );
        }

        return response()->json($data);
    }
    //UPDATE
    public function update_officer_information(Request $request)
    {
        $where = array('cso_officer_id' => $request->input('officer_id'));

        $data = array(
            'officer_cso_id' => $request->input('cso_id'),
            'position_number' => explode("-", $request->input('update_cso_position'))[1],
            'first_name' => $request->input('update_first_name'),
            'middle_name' => ($request->input('update_middle_name') == '') ? '' : $request->input('update_middle_name'),
            'last_name' => $request->input('update_last_name'),
            'extension' => ($request->input('update_extension') == '') ? '' : $request->input('update_extension'),
            'cso_position' => $request->input('update_cso_position'),
            'contact_number' => $request->input('update_contact_number'),
            'email_address' => $request->input('update_email'),


        );


        $update = $this->customRepository->update_item($this->conn, 'cso_officers', $where, $data);
        if ($update) {
            $cso = $this->customRepository->q_get_where($this->conn, array('cso_id' => $data['officer_cso_id']), 'cso')->first();
            $this->actionLogService->add_pmas_rfa_action('cso', $cso->cso_id, 'Updated ' . $data['first_name'] . ' ' . $data['middle_name'] . ' ' . $data['last_name'] . ' ' . $data['extension'] . ' as ' . $data['cso_position'] . ' of ' . $cso->cso_name);
            $data = array(
                'message' => 'Updated Succesfully',
                'response' => true
            );
        } else {
            $data = array(
                'message' => 'Something Wrong',
                'response' => false
            );
        }
        return response()->json($data);
    }
    //DELETE

    public function delete_cso_officer(Request $request)
    {
        $where = array(
            'cso_officer_id' => $request->input('id')
        );
        $delete = $this->customRepository->delete_item($this->conn, 'cso_officers', $where);
        if ($delete) {
            $data = array(
                'message' => 'CSO Added Succesfully',
                'response' => true
            );
        } else {
            $data = array(
                'message' => 'Something Wrong',
                'response' => false
            );
        }
        return response()->json($data);
    }


    //Projects


    //CREATE

    public function add_project(Request $request)
    {

        $data = array(
            'title_of_project' => $request->input('title_of_project'),
            'amount' => $request->input('amount'),
            'year' => date("Y-m-d", strtotime($request->input('year'))),
            'funding_agency' => $request->input('funding_agency'),
            'status' => 'active',
            'cso_project_created' => Carbon::now()->format('Y-m-d H:i:s'),
            'project_cso_id' => $request->input('cso_idd')
        );



        $result = $this->customRepository->insert_item($this->conn, 'cso_project_implemented', $data);
        if ($result) {
            $data = array(
                'message' => 'Project Added Succesfully',
                'response' => true
            );
        } else {
            $data = array(
                'message' => 'Something Wrong',
                'response' => false
            );
        }
        return response()->json($data);

    }

    //READ
    public function get_projects(Request $request)
    {

        $data = [];
        $item = $this->customRepository->q_get_where_order($this->conn, 'cso_project_implemented', array('project_cso_id' => $request->input('cso_id')), 'cso_project_created', 'desc')->get();
        foreach ($item as $row) {

            $status = $row->status == "active" ? '<a href="javascript:;" class="btn btn-success btn-rounded p-1 pl-1 pr-1">Active</a> ' : '<a href="javascript:;" class="btn btn-danger btn-rounded p-1 pl-1 pr-1">Inactive</a> ';

            $data[] = array(

                'project_title' => $row->title_of_project,
                'amount' => number_format($row->amount, 2, '.', ','),
                'year' => $row->year != NULL ? date('Y', strtotime($row->year)) : '',
                'year1' => $row->year != NULL ? date('Y-m-d', strtotime($row->year)) : '',
                'funding_agency' => $row->funding_agency,
                'status' => $status,
                'status1' => $row->status,
                'cso_project_id' => $row->cso_project_implemented_id
            );
        }

        return response()->json($data);

    }
    //UPDATE
    public function update_project(Request $request)
    {

        $data = array(
            'title_of_project' => $request->input('update_title_of_project'),
            'amount' => $request->input('update_amount'),
            'year' => date("Y-m-d", strtotime($request->input('update_year'))),
            'funding_agency' => $request->input('update_funding_agency'),
            'status' => $request->input('update_status'),
        );

        $where = array(
            'cso_project_implemented_id' => $request->input('cso_project_id')
        );

        $update = $this->customRepository->update_item($this->conn, 'cso_project_implemented', $where, $data);
        if ($update) {
            $data = array(
                'message' => 'Updated Succesfully',
                'response' => true
            );
        } else {
            $data = array(
                'message' => 'Something Wrong',
                'response' => false
            );
        }
        return response()->json($data);
    }
    //DELETE

    public function delete_cso_project(Request $request)
    {

        $where = array(
            'cso_project_implemented_id' => $request->input('id')
        );

        $delete = $this->customRepository->delete_item($this->conn, 'cso_project_implemented', $where);
        if ($delete) {
            $data = array(
                'message' => 'Deleted Succesfully',
                'response' => true
            );
        } else {
            $data = array(
                'message' => 'Something Wrong',
                'response' => false
            );
        }
        return response()->json($data);

    }


    //Activities
    public function cso_activities_data(Request $request)
    {
        $year = $request->input('year');
        $cso_id = $request->input('cso_id');

        $activities = array();
        $activity_row = $this->customRepository->q_get_order($this->conn, 'type_of_activities', 'type_of_activity_name', 'asc')->get();

        foreach ($activity_row as $row) {

            $count_cso_act = $this->cSOQuery->count_cso_activities($year, $row->type_of_activity_id, $cso_id);
            array_push($activities, $row->type_of_activity_name . ' - ' . $count_cso_act);
        }

        $data['label'] = $activities;
        return response()->json($data);

    }


    public function upload_cso_file(Request $request)
    {



        $cso_id = $request->input('cso_id');
        $file_type = $request->input('file_type');

        $path = storage_path() . "/uploads/cso_files/" . $request->input('cso_id') . '/';

        $action = '';
        $cso_row = $this->customRepository->q_get_where($this->conn, array('cso_id' => $cso_id), 'cso')->first();

        switch ($file_type) {
            case 'cor':
                $file_path = $path . config('custom_config.folder_name.cor_folder_name');
                $action = 'COR';
                break;
            case 'bylaws':
                $file_path = $path . config('custom_config.folder_name.bylaws_folder_name');
                $action = 'Bylaws';
                break;
            case 'aoc':
                $file_path = $path . config('custom_config.folder_name.aoc_folder_name');
                $action = 'AOC/AOI';
                break;

        }

        if (!is_dir($file_path)) {
            mkdir($file_path, 0777, true);
        }


        $allFiles = scandir($file_path);
        $files = array_diff($allFiles, array('.', '..'));
        if ($files > 0) {
            foreach ($files as $file) {
                unlink($file_path . '/' . $file);
            }
        }

        $destination = '';
        $new_name = '';

        if (is_dir($file_path)) {

            if (isset($_FILES['update_file'])) {
                $new_name = $_FILES['update_file']['name'];
                $destination = $file_path . '/' . $new_name;
                move_uploaded_file($_FILES['update_file']['tmp_name'], $destination);
            }

            if (file_exists($destination)) {
                $this->actionLogService->add_pmas_rfa_action('cso', $cso_row->cso_id, 'Uploaded ' . $action . ' of ' . $cso_row->cso_name);
                $data = array(
                    'message' => 'File Upload Successfully',
                    'response' => true
                );

            } else {


                $data = array(
                    'message' => 'File Upload Error! PLease Try Again',
                    'response' => false
                );

            }


            return response()->json($data);

        }

    }

    public function get_file()
    {
        $type = $_GET['type'];
        $id = $_GET['id'];
        $path = '';
        $file_type = '';
        switch ($type) {

            case 'cor':
                $file_type = config('custom_config.folder_name.cor_folder_name');
                break;

            case 'bylaws':
                $file_type = config('custom_config.folder_name.bylaws_folder_name');
                break;

            case 'articles':
                $file_type = config('custom_config.folder_name.aoc_folder_name');
                break;
        }

        $path = storage_path() . "/uploads/cso_files/" . $id . '/' . $file_type;

        if (is_dir($path)) {

            $file = scandir($path)[2];

            $data = array(

                'file' => url('') . '/storage/uploads/cso_files/' . $id . '/' . $file_type . '/' . $file,
                'resp' => true,
                'message' => ''
            );


        } else {

            $data = array(

                'file' => '',
                'resp' => false,
                'message' => 'Please update COR file'
            );


        }


        return response()->json($data);
    }


}
