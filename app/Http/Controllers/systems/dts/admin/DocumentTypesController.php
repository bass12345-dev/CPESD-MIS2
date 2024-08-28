<?php

namespace App\Http\Controllers\systems\dts\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Services\dts\admin\DashboardService;
use Carbon\Carbon;

class DocumentTypesController extends Controller
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
        $data['title']      = 'Document Types';
        return view('systems.dts.admin.pages.document_types.document_types')->with($data);
    }

    //CREATE
    public function insert_update(Request $request){
        $items = array(
            'type_name'      => $request->input('type'),
        );
        if(empty($request->input('id'))){
            $items["created"] = Carbon::now()->format('Y-m-d H:i:s');
            $insert = $this->customRepository->insert_item($this->conn,'document_types',$items);
            if ($insert) {
            // Registration successful
            return response()->json([
                'message' => 'Document Type Added Successfully', 
                'response' => true
            ], 201);

            }else {
                    return response()->json([
                        'message' => 'Something Wrong', 
                        'response' => false
                    ], 422);
                }
                    
        }else {

            $where = array('type_id' => $request->input('id'));
            $update = $this->customRepository->update_item($this->conn,'document_types',$where,$items);
            if ($update) {
            // Registration successful
            return response()->json([
                'message' => 'Document Type Updated Successfully', 
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
    public function get_document_types(){
        $data = [];
        $i = 1;
        $items = $this->customRepository->q_get($this->conn,'document_types')->get();
        foreach ($items as $value => $key) {
            $data[] = array(
                'number'                => $i++,
                'type_name'             => $key->type_name,
                'type_id'               => $key->type_id,
                'created'               => date('M d Y h:i A', strtotime($key->created))
            );
        }
        return response()->json($data);
    }
    //UPDATE
    //DELETE
    public function delete(Request $request){

        $id = $request->input('id')['id'];
        $check      = $this->customRepository->q_get_where($this->conn,array('doc_type'=>$id),'documents')->count();
        if ($check > 0) {
            $data   = array('message' => 'This Document Types is used in other operation' , 'response' => false);
       }else {
           $delete  = $this->customRepository->delete_item($this->conn,'document_types',array('type_id' => $id));
           
               if($delete) {
                   $data = array('message' => 'Deleted Succesfully' , 'response' => true );
               }else {
                   $data = array('message' => 'Error', 'response' => false);
               }
       }

       return response()->json($data);

    }

   

    



}
