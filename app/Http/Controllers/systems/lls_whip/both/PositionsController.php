<?php

namespace App\Http\Controllers\systems\lls_whip\both;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use Carbon\Carbon;

class PositionsController extends Controller
{
    protected $customRepository;
    protected $conn;
    protected $position_table;
    protected $establishment_employee_table;
    protected $order_by_asc = 'asc';
    protected $order_by_key = 'position';
    public function __construct(CustomRepository $customRepository){
        $this->customRepository     = $customRepository;
        $this->conn                 = config('custom_config.database.lls_whip');
        $this->position_table       = 'positions';
        $this->establishment_employee_table = 'establishment_employee';
    }

    public function  index(){
        $data['title'] = 'WHIP Positions';
        return view('systems.lls_whip.whip.both.positions.lists')->with($data);
    }


    //CREATE
    public function insert_update_position_lls(Request $request){

        $items = array(
            'position'      => $request->input('position'),
            'type'          => 'lls'
        );
        if(empty($request->input('position_id'))){
            $items["created_on"] = Carbon::now()->format('Y-m-d H:i:s');
            $insert = $this->customRepository->insert_item($this->conn,$this->position_table,$items);
            if ($insert) {
            // Registration successful
            return response()->json([
                'message' => 'Position Added Successfully', 
                'response' => true
            ], 201);

            }else {
                    return response()->json([
                        'message' => 'Something Wrong', 
                        'response' => false
                    ], 422);
                }
                    
        }else {

            $where = array('position_id' => $request->input('position_id'));
            $update = $this->customRepository->update_item($this->conn,$this->position_table,$where,$items);
            if ($update) {
            // Registration successful
            return response()->json([
                'message' => 'Position Updated Successfully', 
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

    public function insert_update_position_whip(Request $request){

        $items = array(
            'position'      => $request->input('position'),
            'type'          => 'whip'
        );
        if(empty($request->input('position_id'))){
            $items["created_on"] = Carbon::now()->format('Y-m-d H:i:s');
            $insert = $this->customRepository->insert_item($this->conn,$this->position_table,$items);
            if ($insert) {
            // Registration successful
            return response()->json([
                'message' => 'Position Added Successfully', 
                'response' => true
            ], 201);

            }else {
                    return response()->json([
                        'message' => 'Something Wrong', 
                        'response' => false
                    ], 422);
                }
                    
        }else {

            $where = array('position_id' => $request->input('position_id'));
            $update = $this->customRepository->update_item($this->conn,$this->position_table,$where,$items);
            if ($update) {
            // Registration successful
            return response()->json([
                'message' => 'Position Updated Successfully', 
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
    public function get_all_lls_positions(){
        $es = $this->customRepository->q_get_where_order($this->conn,$this->position_table,array('type' => 'lls'),$this->order_by_key,$this->order_by_asc)->get();
        $items = [];
        foreach ($es as $row) {
           $items[] = array(
                    'position_id'     => $row->position_id,
                    'position'        => $row->position,
                    'created'         => date('M d Y - h:i a', strtotime($row->created_on)),
           );
        }
        return response()->json($items);
    }
    public function get_all_whip_positions(){
        $es = $this->customRepository->q_get_where_order($this->conn,$this->position_table,array('type' => 'whip'),$this->order_by_key,$this->order_by_asc)->get();
        $items = [];
        foreach ($es as $row) {
           $items[] = array(
                    'position_id'     => $row->position_id,
                    'position'        => $row->position,
                    'created'         => date('M d Y - h:i a', strtotime($row->created_on)),
           );
        }
        return response()->json($items);
    }
    //UPDATE
    //DELETE
    public function delete_positions(Request $request)
    {

        $id = $request->input('id')['id'];
        $message = '';
        if (is_array($id)) {
            foreach ($id as $row) {
                $count = $this->customRepository->q_get_where($this->conn,array('position_id' => $row),$this->establishment_employee_table)->count();
                if($count > 0){
                    $message = 'Some data cannot be deleted because it is used in another operations/';
                }else {
                    $where = array('position_id' => $row);
                    $this->customRepository->delete_item($this->conn,$this->position_table,$where);
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
