<?php

namespace App\Http\Controllers\systems\lls_whip\whip\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use Carbon\Carbon;

class ProjectNatureController extends Controller
{
    protected $customRepository;
    protected $conn;
    protected $nature_table;
    protected $project_table;
    protected $order_by_asc = 'asc';
    protected $order_by_key = 'project_nature';
    public function __construct(CustomRepository $customRepository){
        $this->customRepository     = $customRepository;
        $this->conn                 = config('custom_config.database.lls_whip');
        $this->nature_table         = 'project_nature';
        $this->project_table        = 'projects';
    }

    public function index(){

        $data['title'] = 'Project Nature';
        return view('systems.lls_whip.whip.admin.pages.project_nature.lists')->with($data);
    }

    //CREATE
    public function insert_update_nature(Request $request){

        $items = array(
            'project_nature'      => $request->input('project_nature'),
        );
        if(empty($request->input('project_nature_id'))){
            $items["created_on"] = Carbon::now()->format('Y-m-d H:i:s');
            $insert = $this->customRepository->insert_item($this->conn,$this->nature_table,$items);
            if ($insert) {
            // Registration successful
            return response()->json([
                'message' => 'Project Nature Added Successfully', 
                'response' => true
            ], 201);

            }else {
                    return response()->json([
                        'message' => 'Something Wrong', 
                        'response' => false
                    ], 422);
                }
                    
        }else {

            $where = array('project_nature_id' => $request->input('project_nature_id'));
            $update = $this->customRepository->update_item($this->conn,$this->nature_table,$where,$items);
            if ($update) {
            // Registration successful
            return response()->json([
                'message' => 'Project Nature Updated Successfully', 
                'response' => true
            ], 201);

            }else {
                    return response()->json([
                        'message' => 'Something Wrong', 
                        'response' => false
                    ], 422);
                }
            
        }
    }
    //READ
    public function get_all_project_nature(){
        $es = $this->customRepository->q_get_order($this->conn,$this->nature_table,$this->order_by_key,$this->order_by_asc)->get();
        $items = [];
        foreach ($es as $row) {
           $items[] = array(
                    'project_nature_id'     => $row->project_nature_id,
                    'project_nature'        => $row->project_nature,
                    'created'         =>    date('M d Y - h:i a', strtotime($row->created_on)),
           );
        }
        return response()->json($items);
    }
    //UPDATE
    //DELETE
    public function delete_project_nature(Request $request)
    {

        $id = $request->input('id')['id'];
        $message = '';
        if (is_array($id)) {
            foreach ($id as $row) {
                $count = $this->customRepository->q_get_where($this->conn,array('project_nature_id' => $row),$this->project_table)->count();
                if($count > 0){
                    $message = 'Some data cannot be deleted because it is used in another operations/';
                }else {
                    $where = array('project_nature_id' => $row);
                    $this->customRepository->delete_item($this->conn,$this->nature_table,$where);
                    $message = 'Deleted Successfully/';
                }
            }

            $data = array('message' => $message, 'response' => true);
        } else {
            $data = array('message' => 'Error', 'response' => false);
        }



        return response()->json($data);
    }
}
