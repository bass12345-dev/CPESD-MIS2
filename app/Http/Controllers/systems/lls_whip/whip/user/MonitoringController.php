<?php

namespace App\Http\Controllers\systems\lls_whip\whip\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\whip\ProjectEmployeeStoreRequest;
use App\Services\whip\user\MonitoringService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Repositories\CustomRepository;
use App\Repositories\whip\EmployeeQuery;
use App\Repositories\whip\MonitoringQuery;
use App\Repositories\whip\ProjectQuery;
use App\Services\CustomService;
use App\Services\user\UserService;
use App\Services\whip\ProjectsService;

class MonitoringController extends Controller
{   
    protected $conn;
    protected $customRepository;
    protected $monitoringQuery;
    protected $customService;
    protected $projectsService;
    protected $monitoringService;
    protected $userService;
    protected $projectQuery;
    protected $employeeQuery;
    protected $monitoring_table;
    protected $position_table;
    protected $employment_status_table;
    protected $project_employee_table;
    public function __construct(CustomRepository $customRepository, ProjectQuery $projectQuery, EmployeeQuery $employeeQuery ,CustomService $customService, ProjectsService $projectsService,MonitoringQuery $monitoringQuery ,MonitoringService $monitoringService, UserService $userService){
        $this->conn                 = config('custom_config.database.lls_whip');
        $this->customRepository     = $customRepository;
        $this->customService        = $customService;
        $this->monitoringService    = $monitoringService;
        $this->projectsService      = $projectsService;
        $this->projectQuery         = $projectQuery;
        $this->employeeQuery        = $employeeQuery;
        $this->monitoringQuery      = $monitoringQuery;
        $this->userService          = $userService;
        $this->monitoring_table     = 'project_monitoring';
        $this->position_table       = 'positions';
        $this->employment_status_table = 'employment_status';
        $this->project_employee_table = 'project_employee';
    }
    public function add_monitoring_view(){
        $data['title'] = 'Add New Monitoring';
        return view('systems.lls_whip.whip.user.pages.project_monitoring.add_new.add_new')->with($data);
    }

    public function pending_project_monitoring_view(){
        $data['title'] = 'Pending Project Monitoring';
        return view('systems.lls_whip.whip.user.pages.project_monitoring.pending_list.lists')->with($data);
    }  

    public function approved_project_monitoring_view(){
        $data['title'] = 'Approved Project Monitoring';
        $data['current']            = Carbon::now()->year.'-'.Carbon::now()->month;
        return view('systems.lls_whip.whip.user.pages.project_monitoring.approved_list.lists')->with($data);
    }
    
    public function project_monitoring_information($id){
        
        $count = $this->projectQuery->get_monitoring_information(array('project_monitoring_id' => $id));
        if($count->count() > 0 ){
            $row                = $count->first();
            $data['title']      = 'Pending Project Monitoring '.$row->project_title;
            $data['row']        = $row;
            $data['positions']    =  $this->customRepository->q_get_where_order($this->conn,$this->position_table,array('type' => 'whip'),'position','asc')->get();
            $data['employment_status']      = $this->customRepository->q_get_order($this->conn,$this->employment_status_table,'status','asc')->get();
            $data['nature_of_employment']   = config('custom_config.whip_nature_of_employment');
            $data['level_of_employment']    = config('custom_config.level_of_employment');
            return view('systems.lls_whip.whip.user.pages.project_monitoring.view_monitoring.view_monitoring')->with($data);
        }else {
            echo '404';
        }
       
    }

    public function view_monitoring_report($id){
        $count = $this->projectQuery->get_monitoring_information(array('project_monitoring_id' => $id));
        if($count->count() > 0 ){
            $row                = $count->first();
            $data['title']      = $row->project_title;
            $data['row']        = $row;
            return view('systems.lls_whip.whip.user.pages.project_monitoring.report.report')->with($data);
        }else {
            echo '404';
        }
    }


    //CREATE
    public function insert_project_monitoring(Request $request){
    
        $items = array(
            'project_id'            => $request->input('project_id'),
            'whip_code'             => $request->input('whip_code'),
            'date_of_monitoring'    => $request->input('date_of_monitoring'),
            'specific_activity'     => $request->input('specific_activity'),
            'annotations'           => $request->input('annotations'),
            'monitoring_status'     => 'pending',
            'added_by'              => session('user_id'),
            'created_on'            => Carbon::now()->format('Y-m-d H:i:s'),
        );

        $insert = $this->customRepository->insert_item($this->conn,$this->monitoring_table,$items);
        if ($insert) {
            // Registration successful
            return response()->json([
                'message' => 'Project Monitoring Added Successfully', 
                'response' => true
            ], 201);
        }else {
            return response()->json([
                'message' => 'Something Wrong', 
                'response' => false
            ], 422);
        }   
    }

    public function insert_update_project_employee(Request $request){

        
   
        $items = array(
            'employee_id'                   => $request->input('employee_id'),
            'project_id'                   => $request->input('project_id'),
            'position_id'                   => $request->input('position'),
            'nature_of_employment'          => $request->input('employment_nature'),
            'status_of_employment_id'       => $request->input('employment_status'),  
            'start_date'                    => NULL,
            'end_date'                      => NULL,
            'level_of_employment'           => $request->input('employment_level'),
            'project_monitoring_id'         => $request->input('project_monitoring_id'),
            'location_status'               => $request->input('location_status'),
        );

        if(empty($request->input('project_employee_id'))){
            if(!empty($items['employee_id'])){
                $resp = $this->projectsService->insert_project_employee($items);
            }else {
                $resp = [
                    'message' => 'Please Search Employee Properly', 
                    'response' => false
                ];
            }     
        }else {
            $where = array('project_employee_id' => $request->input('project_employee_id'));
            $resp = $this->projectsService->update_project_employee($where,$items);
        }
        return response()->json($resp);
    }

    public function add_remarks(Request $request){
       $items = array(
                'remarks'   => $request->input('remarks'),
                'user_id'   => session('user_id'),
                'seen_status'   => 'unseen',
                'created_on'    => Carbon::now()->format('Y-m-d H:i:s'),
                'project_monitoring_id' => $request->input('project_monitoring_id')
       );

       $insert = $this->customRepository->insert_item($this->conn,'remarks',$items);
       if ($insert) {
           // Registration successful
           return response()->json([
               'message' => 'Remarks Successfully', 
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

    public function get_whip_code(){
        
       #define reference number variable
       $whip_number = '';

       #count rfa added in database
       $count_whip = $this->customRepository->q_get($this->conn, 'project_monitoring')->count();

       #get current year
       $current_year = date('Y', time());

       #ymd format = Year Month Day
       $ymd_format = date('Y-m-d', time());
        
       $add_str = date('Ymd', time());

       #CONDITION

       if ($count_whip) {

             $last_created = date('Y', strtotime($this->customRepository->q_get_order($this->conn, 'project_monitoring', 'created_on', 'desc')->first()->created_on));

             if ($current_year > $last_created) {

                   $whip_number = $add_str.'001';

             } else if ($current_year < $last_created) {
                   $last_pmas_number_add_one = (int)$this->monitoringQuery->get_whip_code($ymd_format)->first()->whip_code + 1;
                   $whip_number = $this->customService->put_zeros_p_r($last_pmas_number_add_one);

             } else if ($current_year === $last_created) {
                   $last_pmas_number_add_one = $this->monitoringQuery->get_whip_code($current_year)->first()->whip_code + 1;
                   $whip_number = $this->customService->put_zeros_p_r($last_pmas_number_add_one);

             }

       } else {

             $whip_number = $add_str.'001';
       }

       echo $whip_number;

    }

    public function get_my_approved_project_monitoring(){
        
            $month = '';
            $year = '';
            if(isset($_GET['date'])){
                $month =   date('m', strtotime($_GET['date']));
                $year =   date('Y', strtotime($_GET['date']));
            }
            
            $data = $this->monitoringService->get_my_approved_monitoring($month,$year);
            return response()->json($data);
        
    }


    public function get_remarks(Request $request){

        $where = array('project_monitoring_id' => $request->input('id'),'user_id' => session('user_id'));
        $items = array(
                    'seen_status'    => 'seen',
        );
        $this->customRepository->update_item($this->conn,'remarks',$where,$items);
        $remarks = $this->monitoringQuery->QueryRemarks($where['project_monitoring_id']);
        $arr = [];
        foreach ($remarks as $row) {
            $arr[] = array(
                'user' => $row->user_id == session('user_id') ? 'me' : 'other',
                'name'  => $this->userService->user_full_name($row),
                'remarks' => $row->remarks
            );
        }

        return response()->json($arr);
     }
   
    public function get_all_project_employee(Request $request){
       $id = $request->input('id');
       $items = $this->projectQuery->get_project_employee($id);
       $data = [];
       $i = 1;
        foreach ($items as $row) {
           $data[] = array(
                    'i'                => $i++,
                    'project_employee_id'   => $row->project_employee_id,
                    'employee_id'           => $row->employee_id,
                    'full_name'             => $this->userService->user_full_name($row),
                    'full_address'          => $this->userService->full_address($row),
                    'position'              => $row->position,
                    'position_id'           => $row->position_id,
                    'nature_of_employment'  => $row->nature_of_employment,
                    'status_id'             => $row->employment_status_id,
                    'status_of_employment'  => $row->status,
                    'start_date'            =>  $row->start_date == NULL ? '-' :  Carbon::parse($row->start_date)->format('M Y'),
                    'end_date'              => $row->end_date == NULL ? '-' :  Carbon::parse($row->end_date)->format('M Y'),
                    'level_of_employment'   => $row->level_of_employment,
                    'gender'                => $row->gender,
                    'location_status'       => $row->location_status
           );
        }
        return response()->json($data);
    }


    public function get_pending_project_monitoring(Request $request){

        $items = $this->monitoringQuery->get_user_pending_monitoring();
            // $items = $this->monitoringQuery->get_admin_pending_monitoring();
        
        $data = [];
        $i = 1;
        foreach ($items as $row) {
           $data[] = array(
                    'i'                             => $i++,
                    'project_monitoring_id'         => $row->project_monitoring_id,
                    'code'                          => $row->whip_code,
                    'project_title'                 => $row->project_title,
                    'date_of_monitoring'            => date('M d Y ', strtotime($row->date_of_monitoring)),
                    'specific_activity'             => $row->specific_activity,
                    'monitoring_status'             => $row->monitoring_status,
                    'contractor'                    => $row->contractor_name,
                    'address'                       => $row->barangay.' '.$row->street,
                    'person_responsible'            => $this->userService->user_full_name($row),
                    'count_unseen'                  => $this->customRepository->q_get_where($this->conn,array('project_monitoring_id' => $row->project_monitoring_id,'seen_status' => 'un'),'remarks')->count()
                   
           );
        }

        return response()->json($data);
    }




    //Reports

    public function get_nature_employee_inside(Request $request) {  
        $id             = $request->input('id');
        $project_id     = $request->input('project_id');
        $res            = $this->employeeQuery->nature_inside($id,$project_id);
        $nature         = [];
        $total          = [];
        foreach ($res as $row) {
            $nature[]   = $row->nature_of_employment;
            $total[]    = $row->count_nature;
        }
       $data['label']   = $nature;
       $data['total']   = $total;
       $data['color']   = ['#2E236C','#684B49'];
       return response()->json($data);
       
    }

    public function get_nature_employee_outside(Request $request) {  
        $id             = $request->input('id');
        $project_id     = $request->input('project_id');
        $res            = $this->employeeQuery->nature_outside($id,$project_id);
        $nature         = [];
        $total          = [];
        foreach ($res as $row) {
            $nature[]   = $row->nature_of_employment;
            $total[]    = $row->count_nature;
        }
       $data['label']   = $nature;
       $data['total']   = $total;
       $data['color']   = ['#2E236C','#684B49'];
       return response()->json($data);
       
    }


    public function get_skilled_unskilled_total(Request $request){
        $id             = $request->input('id');
        $project_id     = $request->input('project_id');
        $data = $this->employeeQuery->get_unskilled_and_skilled($id,$project_id);
        return response()->json($data);

    }

    


    //UPDATE
    public function update_project_monitoring(Request $request){
        $where = array('project_monitoring_id' => $request->input('project_monitoring_id'));
        $items = array(

                    'date_of_monitoring'    => $request->input('date_of_monitoring'),
                    'specific_activity'     => $request->input('specific_activity'),   
                    'annotations'           => $request->input('annotations'),
        );

        $update = $this->customRepository->update_item($this->conn,$this->monitoring_table,$where,$items);
        if ($update) {
        // Registration successful
        return response()->json([
            'message' => 'Project Monitoring Updated Successfully', 
            'response' => true
        ], 201);

        }else {
                return response()->json([
                    'message' => 'Something Wrong', 
                    'response' => false
                ], 422);
            }
    }
    //DELETE

    public function delete_project_monitoring(Request $request){

        $id = $request->input('id')['id'];
        if (is_array($id)) {
            foreach ($id as $row) {
               $where = array('project_monitoring_id' => $row);
               $this->customRepository->delete_item($this->conn,$this->monitoring_table,$where);
               $this->customRepository->delete_item($this->conn,$this->project_employee_table,$where);
            }
            
            $data = array('message' => 'Deleted Succesfully', 'response' => true);
        } else {
            $data = array('message' => 'Error', 'response' => false);
        }



        return response()->json($data);

    }

    public function delete_project_employee(Request $request){

        $id = $request->input('id')['id'];
        if (is_array($id)) {
            foreach ($id as $row) {
               $where = array('project_employee_id' => $row);
               $this->customRepository->delete_item($this->conn,$this->project_employee_table,$where);
            }

            $data = array('message' => 'Deleted Succesfully', 'response' => true);
        } else {
            $data = array('message' => 'Error', 'response' => false);
        }



        return response()->json($data);

    }

   //REPORT
   public function generate_report(Request $request){
       $project_monitoring_id = $request->input('project_monitoring_id');
       $project_id = $request->input('project_id');
       $row =  $this->projectQuery->get_monitoring_information(array('project_monitoring_id' => $project_monitoring_id))->first();
       $count_total_skilled = 0;
       $skilled_percentage = 0;
       $count_total_unskilled = 0;
       $unskilled_percentage = 0;
       $total = 0;
       $count_total_skilled = $this->customRepository->q_get_where($this->conn,array('project_monitoring_id' => $project_monitoring_id,'project_id' => $project_id,'nature_of_employment' => 'skilled'),$this->project_employee_table)->count();
       $count_total_unskilled = $this->customRepository->q_get_where($this->conn,array('project_monitoring_id' => $project_monitoring_id,'project_id' => $project_id,'nature_of_employment' => 'unskilled'),$this->project_employee_table)->count();
       $total = $count_total_skilled + $count_total_unskilled;

       $skilled_percentage  =  $count_total_skilled == 0 ? 0 :   (int) $count_total_skilled / (int) $total * 100;
       $unskilled_percentage = $count_total_unskilled == 0 ? 0 :   (int) $count_total_skilled / (int) $total * 100;

       $inside_oroquieta            = $this->employeeQuery->nature_inside($project_monitoring_id,$project_id);
       $outside_oroquieta            = $this->employeeQuery->nature_outside($project_monitoring_id,$project_id);

       $within_the_project      = $this->employeeQuery->within_project($project_monitoring_id,$project_id,$row->barangay);

       $near_project      = $this->employeeQuery->location_status_project($project_monitoring_id,$project_id,'near');
       $far_project      = $this->employeeQuery->location_status_project($project_monitoring_id,$project_id,'far');


       $data = array(
            'data' => $row,
            'name' => $this->userService->user_full_name($row),
            'total' => $total,
            's_u' => array(
                'skilled' => $count_total_skilled,
                'skilled_percentage' => $skilled_percentage.'%',
                'unskilled' => $count_total_unskilled,
                'unskilled_percentage' => $unskilled_percentage.'%',
            ),
            'inside_oroquieta' =>  $inside_oroquieta,
            'outside_oroquieta' => $outside_oroquieta,
            'within_project'    => $within_the_project,
            'near_project'      => $near_project,
            'far_project'       => $far_project
            


       );

       return response()->json($data);

       
   }
}
