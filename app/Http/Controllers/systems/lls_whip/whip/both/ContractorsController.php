<?php

namespace App\Http\Controllers\systems\lls_whip\whip\both;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\whip\ContractorStoreRequest;
use App\Repositories\CustomRepository;
use App\Repositories\whip\ContractorQuery;
use App\Repositories\whip\ProjectQuery;
use App\Services\CustomService;
use App\Services\user\UserService;
use App\Services\whip\ContractorsService;
use Carbon\Carbon;

class ContractorsController extends Controller
{
    protected $contractorService;
    protected $customService;
    protected $userService;
    protected $customRepository;
    protected $Contractorquery;
    protected $projectQuery;
    protected $conn;
    protected $contractors_table;
    protected $projects_table;
    protected $order_by_asc = 'asc';
    protected $order_by_desc = 'desc';
    protected $order_by_key = 'contractor_id';
    public function __construct(CustomRepository $customRepository, UserService $userService,ContractorsService $contractorService, ContractorQuery $contractorQuery, CustomService $customService, ProjectQuery $projectQuery){
        $this->conn                 = config('custom_config.database.lls_whip');
        $this->customRepository     = $customRepository;
        $this->contractorService    = $contractorService;
        $this->customService        = $customService;
        $this->contractors_table    = 'contractors';
        $this->projects_table       = 'projects';
        $this->Contractorquery      = $contractorQuery;
        $this->projectQuery         = $projectQuery;
        $this->userService          = $userService;
    }
    public function add_new_contractor(){
        $data['title'] = 'Add New Contractor';
        return view('systems.lls_whip.whip.both.contractors.add_new.add_new')->with($data);
    }

    public function contractors_list(){
        $data['title'] = 'Contractors List';
        return view('systems.lls_whip.whip.both.contractors.lists.lists')->with($data);
    }

    public function contractor_information($id){
        $count = $this->customRepository->q_get_where($this->conn,array('contractor_id' => $id),$this->contractors_table);
        if($count->count() > 0){

            $row = $count->first();
            $data['pending']= $this->customRepository->q_get_where($this->conn,array('contractor_id' => $id,'project_status' => 'ongoing'),$this->projects_table)->count();
            $data['completed']= $this->customRepository->q_get_where($this->conn,array('contractor_id' => $id,'project_status' => 'completed'),$this->projects_table)->count();
            $data['title']  = $row->contractor_name;
            $data['row']    = $row;
            return view('systems.lls_whip.whip.both.contractors.view.view')->with($data);

        }else {
            echo '404';
        }
        
    }

    //CREATE
    public function insert_contractor(ContractorStoreRequest $request){
        $validatedData = $request->validated();
        $insert = $this->contractorService->registerContractor($validatedData);
        
        if ($insert) {
            // Registration successful
            return response()->json([
                'message' => 'Contractor Added Successfully', 
                'response' => true
            ], 201);
        }else {
            return response()->json([
                'message' => 'Something Wrong', 
                'response' => false
            ], 422);
        }
    }
    //READ
    public function get_all_contractors(){
        $contractors = $this->customRepository->q_get_order($this->conn,$this->contractors_table,$this->order_by_key,$this->order_by_asc)->get();
        $items = [];
        foreach ($contractors as $row) {
           $items[] = array(
                    'contractor_id'         => $row->contractor_id,
                    'contractor_name'       => $row->contractor_name,
                    'proprietor'            => $row->proprietor,
                    'full_address'          => $this->userService->full_address($row),
                    'phone_number'          => $row->phone_number,
                    'phone_number_owner'    => $row->phone_number_owner,
                    'telephone_number'      => $row->telephone_number,
                    'email_address'         => $row->email_address,
                    'status'                => $row->status
           );
        }

        return response()->json($items);
    }

    public function get_contractor_projects(Request $request){
        $id = $request->input('id');
        $projects = $this->projectQuery->query_contractor_projects($id);
        $items = [];
        $i = 1;
        foreach ($projects as $row) {
            $items[] = array(
                'i'                 => $i++,
                'project_id'        => $row->project_id,
                'project_title'     => $row->project_title,
                'project_cost'      => $row->project_cost,
                'project_status'    => $row->project_status,
                'project_location'  => $row->barangay.' , '.$row->street,
                'date_started'      => Carbon::parse($row->date_started)->format('M d Y') ,
                'date_completed'    => $row->date_completed == NULL ? ' - ' :  Carbon::parse($row->date_completed)->format('M d Y') ,
                'project_nature'    => $row->project_nature
            );
        }

        return response()->json($items);

    }
    //UPDATE

    public function update_contractor(Request $request){
        $where = array('contractor_id' => $request->input('contractor_id'));
        $update = $this->customRepository->update_item($this->conn,$this->contractors_table,$where,$request->all());
        if ($update) {
            // Registration successful
            return response()->json([
                'message' => 'Contractor Updated Successfully', 
                'response' => true
            ], 201);
        }else {
            return response()->json([
                'message' => 'Something Wrong/No Changes Apply', 
                'response' => false
            ], 422);
        }
    }


    //DELETE
    public function delete_contractors(Request $request){
        $id = $request->input('id')['id'];
        if (is_array($id)) {
            foreach ($id as $row) {
               $where = array('contractor_id' => $row);
               $this->customRepository->delete_item($this->conn,$this->contractors_table,$where);
            }

            $data = array('message' => 'Deleted Succesfully', 'response' => true);
        } else {
            $data = array('message' => 'Error', 'response' => false);
        }
        return response()->json($data);
    }

    //SEARCH
    public function search_query(){
        $q = trim($_GET['key']);
        $emp = $this->Contractorquery->q_search($this->conn,$q);
        $data = [];
        foreach ($emp as $row) {
            $data[] = array(
                'contractor_id'      => $row->contractor_id,
                'contractor_name'    => $row->contractor_name,
                
            );
        }
        return response()->json($data);
    }
}
