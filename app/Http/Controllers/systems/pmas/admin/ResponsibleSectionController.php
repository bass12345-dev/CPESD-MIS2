<?php

namespace App\Http\Controllers\systems\pmas\admin;

use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use App\Repositories\pmas\user\UserPmasQuery;
use App\Services\CustomService;
use App\Services\user\UserService;
use Illuminate\Http\Request;
use Carbon\Carbon;
class ResponsibleSectionController  extends Controller
{

    protected $conn;
    protected $customRepository;
    protected $customService;
    protected $userService;

    protected $userPmasQuery;

    public function __construct(CustomRepository $customRepository, CustomService $customService, UserService $userService, UserPmasQuery $userPmasQuery)
    {

        $this->customRepository = $customRepository;
        $this->userPmasQuery    = $userPmasQuery;
        $this->customService = $customService;
        $this->userService = $userService;
        $this->conn = config('custom_config.database.pmas');
    }
    public function index()
    {
        $data['title'] = 'Responsible Section';
        return view('systems.pmas.admin.pages.responsible_section.responsible_section')->with($data);
    }

    //Create
    public function add_responsible(Request $request)
    {
        $data = array(

            'responsible_section_name'      => $request->input('responsible_section'),
            'responsible_section_created'   => Carbon::now()->format('Y-m-d H:i:s'),
        );

        $result  = $this->customRepository->insert_item($this->conn,'responsible_section', $data);

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
    //Read
    public function get_responsible()
    {
        $data = [];
        $item = $this->customRepository->q_get_order($this->conn, 'responsible_section', 'responsible_section_created', 'desc')->get();
        foreach ($item as $row) {

            $data[] = array(

                'responsible_section_id' => $row->responsible_section_id,
                'responsible_section_name' => $row->responsible_section_name,

            );
        }

        return response()->json($data);
    }
    //Update
    public function update_responsible(Request $request){

        $data = array('responsible_section_name' => $request->input('update_responsible_name') );
        $where = array('responsible_section_id' => $request->input('responsible_id'));

        $update = $this->customRepository->update_item($this->conn,'responsible_section',$where,$data);

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
    public function delete_responsible(Request $request){

        $where = array('responsible_section_id' => $request->input('id'));
        $check = $this->customRepository->q_get_where($this->conn,$where,'transactions')->count();


        if ($check > 0) {

             $data = array(
                    'message' => 'This item is used in other operations',
                    'response' => false
                    );
            
        }else {

             $result = $this->customRepository->delete_item($this->conn,'responsible_section',$where);


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
