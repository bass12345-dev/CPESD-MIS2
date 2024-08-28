<?php

namespace App\Http\Controllers\systems\dts\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Services\dts\admin\DashboardService;
use Carbon\Carbon;

class OfficesController extends Controller
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
        $data['title']      = 'Manage Offices';
        return view('systems.dts.admin.pages.offices.offices')->with($data);
    }

    //CREATE
    public function insert_update_office(Request $request){
        $items = array(
            'office'      => $request->input('office'),
        );
        if(empty($request->input('office_id'))){
            $items["created"] = Carbon::now()->format('Y-m-d H:i:s');
            $insert = $this->customRepository->insert_item($this->conn,'offices',$items);
            if ($insert) {
            // Registration successful
            return response()->json([
                'message' => 'Office Added Successfully', 
                'response' => true
            ], 201);

            }else {
                    return response()->json([
                        'message' => 'Something Wrong', 
                        'response' => false
                    ], 422);
                }
                    
        }else {

            $where = array('office_id' => $request->input('office_id'));
            $update = $this->customRepository->update_item($this->conn,'offices',$where,$items);
            if ($update) {
            // Registration successful
            return response()->json([
                'message' => 'Office Updated Successfully', 
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
    public function get_all_offices(){

        $data = [];
        $i = 1;
        $items = $this->customRepository->q_get($this->conn,'offices')->get();
        foreach ($items as $value => $key) {
            $data[] = array(
                'number'                => $i++,
                'office'                => $key->office,
                'office_id'             => $key->office_id,
                'created'               => date('M d Y h:i A', strtotime($key->created))
            );
        }
        return response()->json($data);
    }
    //UPDATE
    //DELETE

    public function delete_office(Request $request){

        $id = $request->input('id')['id'];
        $check      = $this->customRepository->q_get_where($this->conn,array('offi_id'=>$id),'documents')->count();
        if ($check > 0) {
            $data   = array('message' => 'This Office is used in other operation' , 'response' => false);
       }else {
           $delete  = $this->customRepository->delete_item($this->conn,'offices',array('office_id' => $id));
           
               if($delete) {
                   $data = array('message' => 'Deleted Succesfully' , 'response' => true );
               }else {
                   $data = array('message' => 'Error', 'response' => false);
               }
       }

       return response()->json($data);

    }
    

    



}
