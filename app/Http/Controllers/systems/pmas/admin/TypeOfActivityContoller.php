<?php

namespace App\Http\Controllers\systems\pmas\admin;
use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use App\Repositories\pmas\user\UserPmasQuery;
use App\Services\CustomService;
use App\Services\user\UserService;
use Illuminate\Http\Request;
use Carbon\Carbon;
class TypeOfActivityContoller extends Controller
{

    protected $conn;
    protected $customRepository;
    protected $customService;
    protected $userService;

    protected $userPmasQuery;

    public function __construct(CustomRepository $customRepository, CustomService $customService, UserService $userService, UserPmasQuery $userPmasQuery)
    {

        $this->customRepository = $customRepository;
        $this->userPmasQuery = $userPmasQuery;
        $this->customService = $customService;
        $this->userService = $userService;
        $this->conn = config('custom_config.database.pmas');

    }
    public function index()
    {
        $data['title'] = 'Type of Activities';
        return view('systems.pmas.admin.pages.type_of_activities.type_of_activities')->with($data);
    }

   

    //Create
    public function add_activity(Request $request)
    {
        $data = array(
            'type_of_activity_name' => $request->input('activity'),
            'type_act_created' => Carbon::now()->format('Y-m-d H:i:s'),
        );

        $result = $this->customRepository->insert_item($this->conn, 'type_of_activities', $data);

        if ($result) {

            $data = array(
                'message' => 'Data Saved Successfully',
                'response' => true
            );

        } else {

            $data = array(
                'message' => 'Error',
                'response' => false
            );
        }

        return response()->json($data);
    }

    public function add_under_type_of_activity(Request $request){

        $data = array(

            'under_type_act_name'       => $request->input('under_type_activity'),
            'typ_ac_id'                 => $request->input('act_id'),
            'under_type_act_created'   => Carbon::now()->format('Y-m-d H:i:s'),
        );

        $result  = $this->customRepository->insert_item($this->conn,'under_type_of_activity',$data);

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

        return response()->json($data);

    }
    //Read
    public function get_activities()
    {
        $data = [];
        $item = $this->customRepository->q_get_order($this->conn, 'type_of_activities', 'type_of_activity_name', 'asc')->get();
        foreach ($item as $row) {
            $delete = '';
            if (strtolower($row->type_of_activity_name) == 'regular monthly meeting' || strtolower($row->type_of_activity_name) == 'regular monthly project monitoring') {
                $delete = '';
            } else {
                $delete = '<li><a href="javascript:;" data-id="' . $row->type_of_activity_id . '" data-name="' . $row->type_of_activity_name . '"  id="delete-activity"  class="text-danger action-icon"><i class="ti-trash"></i></a></li>';
            }

            $data[] = array(

                'type_of_activity_id' => $row->type_of_activity_id,
                'type_of_activity_name' => $row->type_of_activity_name,
                'action' => strtolower($row->type_of_activity_name) != 'training' ?
                    '<ul class="d-flex justify-content-center">
                            <li class="mr-3 "><a href="javascript:;" class="text-secondary action-icon" data-id="' . $row->type_of_activity_id . '" data-name="' . $row->type_of_activity_name . '" data-toggle="modal" data-target="#update_type_of_activity_modal" id="update-activity"><i class="fa fa-edit"></i></a></li>' . $delete . '
                        </ul>' : '<ul class="d-flex justify-content-center">
                                    <li class="mr-3 "><a href="javascript:;" class="text-secondary action-icon" data-id="' . $row->type_of_activity_id . '" data-name="' . $row->type_of_activity_name . '" id="add-under-activity"><i class="fa fa-arrow-down"></i></a></li>
                                </ul>'

            );
        }

        return response()->json($data);
    }

    public function get_under_type_of_activity(Request $request){

        $data = [];
        $row = $this->customRepository->q_get_where_order($this->conn,'under_type_of_activity',array('typ_ac_id' => $request->input('id')),'under_type_act_name','asc');

        if($row->count() > 0){
                $items = $row->get();
                foreach ($items as $row) {
            
                    $data[] = array(
    
                            'under_type_act_name' => $row->under_type_act_name,
                            'typ_ac_id' => $row->typ_ac_id,
                            'under_type_act_id' => $row->under_type_act_id 
                    );
            }
    
        }
        return response()->json($data);

    }
    //Update
    public function update_activity(Request $request)
    {
        $data = array('type_of_activity_name' => $request->input('update_type_of_activity'));
        $where = array(
            'type_of_activity_id' => $request->input('activity_id')
        );
        $update = $this->customRepository->update_item($this->conn,'type_of_activities',$where, $data);
        if ($update) {

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

    public function update_under_type_of_activity(Request $request){

    $data = array('under_type_act_name' => $request->input('under_update_type_of_activity') );
    $where = array('under_type_act_id' => $request->input('under_activity_id'));
    $update = $this->customRepository->update_item($this->conn,'under_type_of_activity',$where,$data);
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
    public function delete_activity(Request $request)
    {

        $where = array('type_of_activity_id' => $request->input('id'));
        $check = $this->customRepository->q_get_where($this->conn, $where, 'transactions')->count();
        if ($check > 0) {

            $data = array(
                'message' => 'This type of activity is used in other operations',
                'response' => false
            );
        } else {

            $result = $this->customRepository->delete_item($this->conn, 'type_of_activities', $where);

            if ($result) {

                $data = array(
                    'message' => 'Deleted Successfully',
                    'response' => true
                );

            } else {

                $data = array(
                    'message' => 'Error',
                    'response' => false
                );
            }

        }


        return response()->json($data);
    }

    public function delete_under_activity(Request $request){

        $where1 = array('under_type_of_activity_id' => $request->input('id'));
        $where2 = array('under_type_act_id' => $request->input('id'));
        $check = $this->customRepository->q_get_where($this->conn,$where1,'transactions')->count();
        if ($check > 0) {

             $data = array(
                    'message' => 'This data is used in other operations',
                    'response' => false
                    );
        }else {
             $result = $this->customRepository->delete_item($this->conn,'under_type_of_activity',$where2);
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
