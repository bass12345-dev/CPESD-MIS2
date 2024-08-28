<?php

namespace App\Http\Controllers\systems\dts\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Services\dts\admin\DashboardService;
use Carbon\Carbon;

class FinalActionsController extends Controller
{
    protected $conn;
    protected $customRepository;
    protected $dashboardService;
    public function __construct(CustomRepository $customRepository, DashboardService $dashboardService){
        $this->conn                 = config('custom_config.database.dts');
        $this->customRepository     = $customRepository;
        $this->dashboardService     = $dashboardService;
     
    }
    public function index(){
        $data['title']      = 'Final Actions';
        return view('systems.dts.admin.pages.final_actions.final_actions')->with($data);
    }

    //CREATE
    public function insert_update(Request $request){
        $items = array(
            'action_name'      => $request->input('action'),
        );
        if(empty($request->input('id'))){
            $items["created"] = Carbon::now()->format('Y-m-d H:i:s');
            $insert = $this->customRepository->insert_item($this->conn,'final_actions',$items);
            if ($insert) {
            // Registration successful
            return response()->json([
                'message' => 'Final Action Added Successfully', 
                'response' => true
            ], 201);

            }else {
                    return response()->json([
                        'message' => 'Something Wrong', 
                        'response' => false
                    ], 422);
                }
                    
        }else {

            $where = array('action_id' => $request->input('id'));
            $update = $this->customRepository->update_item($this->conn,'final_actions',$where,$items);
            if ($update) {
            // Registration successful
            return response()->json([
                'message' => 'Final Action Updated Successfully', 
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
    public function get_final_actions(){

        $data = [];
        $i = 1;
        $items = $this->customRepository->q_get($this->conn,'final_actions')->get();
        foreach ($items as $value => $key) {
            $data[] = array(
                'number'                => $i++,
                'action_name'           => $key->action_name,
                'action_id'             => $key->action_id,
                'created'               => date('M d Y h:i A', strtotime($key->created))
            );
        }
        return response()->json($data);
    }
    //UPDATE
    //DELETE
    public function delete(Request $request){
        $id = $request->input('id')['id'];
        $check      = $this->customRepository->q_get_where($this->conn,array('final_action_taken'=> $id),'history')->count(); 
        if ($check > 0) {
             $data  = array('message' => 'This action is used in other operation' , 'response' => false);
        }else {
            $delete =  $this->customRepository->delete_item($this->conn,'final_actions',array('action_id' => $id));  
            if($delete) {
                    $data = array('message' => 'Deleted Succesfully' , 'response' => true);
                }else {
                    $data = array('message' => 'Error', 'response' => false);
                }
        }
        return response()->json($data);

    }



}
