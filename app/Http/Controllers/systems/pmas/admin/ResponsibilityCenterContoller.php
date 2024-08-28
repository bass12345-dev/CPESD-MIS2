<?php

namespace App\Http\Controllers\systems\pmas\admin;
use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use App\Repositories\pmas\user\UserPmasQuery;
use App\Services\CustomService;
use App\Services\user\UserService;
use Illuminate\Http\Request;
use Carbon\Carbon;
class ResponsibilityCenterContoller extends Controller
{

    protected $conn;
    protected $customRepository;
    protected $customService;
    protected $userService;

    protected $userPmasQuery;

    public function __construct(CustomRepository $customRepository, CustomService $customService, UserService $userService,UserPmasQuery $userPmasQuery)
    {

        $this->customRepository = $customRepository;
        $this->userPmasQuery    = $userPmasQuery;
        $this->customService = $customService;
        $this->userService = $userService;
        $this->conn = config('custom_config.database.pmas');

    }
    public function index()
    {
        $data['title'] = 'Responsibility Center';
        return view('systems.pmas.admin.pages.responsibility_center.responsibility_center')->with($data);
    }


    //Create
    public function add_responsibility(Request $request){

        $data = array(
            'responsibility_center_code' => $request->input('res_code'),
            'responsibility_center_name' => $request->input('center_name'),
            'responsibility_created'    =>  Carbon::now()->format('Y-m-d H:i:s'),
            );

        $verify = $this->customRepository->q_get_where($this->conn,array('responsibility_center_code' => $data['responsibility_center_code']),'responsibility_center')->count();

        if ($verify > 0) {

            $data = array(
                'message' => 'Error Duplicate Code',
                'response' => false
                );
            
        }else {

            $result  = $this->customRepository->insert_item($this->conn,'responsibility_center',$data);

                if ($result) {

                    $data = array(
                    'message' => 'Data Saved Successfully',
                    'response' => true
                    );
                }else {

                    $data = array(
                    'message' => 'Error',
                    'response' => false
                    );
                }
            
        }

        return response()->json($data);

    }
    //Read
    public function get_responsibility(){
        $data = [];
        $item = $this->customRepository->q_get_order($this->conn,'responsibility_center','responsibility_center_id','desc')->get(); 
        foreach ($item as $row) {
            
                $data[] = array(

                        'responsibility_center_code' => $row->responsibility_center_code,
                        'responsibility_center_name' => $row->responsibility_center_name,
                        'responsibility_center_id' => $row->responsibility_center_id 
                );
        }

        return response()->json($data);
    }
    //Update
    public function update_center(Request $request){

    $data = array('responsibility_center_name' => $request->input('update_center_name') );
    $where = array('responsibility_center_id' => $request->input('center_id'));

       $update = $this->customRepository->update_item($this->conn,'responsibility_center',$where,$data);

          if($update){

              $resp = array(
                  'message' => 'Successfully Updated',
                  'response' => true
              );
          }else {

              $resp = array(
                  'message' => 'Error',
                  'response' => false
              );
          }
        return response()->json($resp);
    }
    //DELETE
    public function  delete_center(Request $request){

        $where = array('responsibility_center_id' => $request->input('id'));
        $check = $this->customRepository->q_get_where($this->conn,$where,'transactions')->count();
        if ($check > 0) {
             $data = array(
                    'message' => 'This item is used in other operations',
                    'response' => false
                    );
        }else {
             $result = $this->customRepository->delete_item($this->conn,'responsibility_center',$where);
            if ($result) {
                    $data = array(
                    'message' => 'Deleted Successfully',
                    'response' => true
                    );
                }else {
                    $data = array(
                    'message' => 'Error',
                    'response' => false
                    );
                }

        }
       

        return response()->json($data);
    }

}
