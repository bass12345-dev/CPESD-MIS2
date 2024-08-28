<?php

namespace App\Http\Controllers\systems\lls_whip\both;

use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmploymentStatusController extends Controller
{
    protected $customRepository;
    protected $conn;
    protected $status_table;
    protected $establishment_employee_table;
    protected $order_by_asc = 'asc';
    protected $order_by_key = 'status';

    public function __construct(CustomRepository $customRepository){
        $this->customRepository = $customRepository;
        $this->conn               = config('custom_config.database.lls_whip');
        $this->establishment_employee_table = 'establishment_employee';
        $this->status_table       = 'employment_status';
    }
    public function index(){
        $data['title'] = 'Employment Status List';
        return view('systems.lls_whip.both.employment_status.lists')->with($data);
    }

    // CREATE
    public function insert_update_status(Request $request){


        $validated = $request->validate([
            'status' => 'required|unique:'.$this->conn.'.employment_status|max:255',
        ]);

        $items = array(
            'status'      => $validated['status'],
        );


        if(empty($request->input('status_id'))){
            $items["created_on"] = Carbon::now()->format('Y-m-d H:i:s');
            $insert = $this->customRepository->insert_item($this->conn,$this->status_table,$items);
            if ($insert) {
                // Registration successful
                return response()->json([
                    'message' => 'Employment Status Added Successfully', 
                    'response' => true
                ], 201);
            }else {
                return response()->json([
                    'message' => 'Something Wrong', 
                    'response' => false
                ], 422);
            }

        }else {
            $where = array('employment_status_id' => $request->input('status_id'));
            $update = $this->customRepository->update_item($this->conn,$this->status_table,$where,$items);
            if ($update) {
            // Registration successful
            return response()->json([
                'message' => 'Employee Status Updated Successfully', 
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

    // READ
    public function get_all_status(){
        $es = $this->customRepository->q_get_order($this->conn,$this->status_table,$this->order_by_key,$this->order_by_asc)->get();
        $items = [];
        foreach ($es as $row) {
           $items[] = array(
                    'employ_stat_id'    => $row->employment_status_id,
                    'status'            => $row->status,
                    'created'           => date('M d Y - h:i a', strtotime($row->created_on)),
           );
        }
        return response()->json($items);
    }
    // UPDATE
    // DELETE
    public function delete_status(Request $request)
    {

        $id = $request->input('id')['id'];
        $message = '';
        if (is_array($id)) {
            foreach ($id as $row) {
                if($row != 5){
                    $count = $this->customRepository->q_get_where($this->conn,array('status_of_employment_id' => $row),$this->establishment_employee_table)->count();
                    if($count > 0){
                        $message = 'Some status cannot be deleted because it is used in another operations/';
                    }else {
                         $where = array('employment_status_id' => $row);
                        $this->customRepository->delete_item($this->conn,$this->status_table,$where);
                        $message = 'Deleted Successfully/';
                    }
                }else {
                    $message = $message.'Active Cannot be Deleted';
                }
               
            }

            $data = array('message' => $message, 'response' => true);
        } else {
            $data = array('message' => 'Error', 'response' => false);
        }



        return response()->json($data);
    }
}