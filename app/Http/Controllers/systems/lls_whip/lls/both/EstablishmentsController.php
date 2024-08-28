<?php

namespace App\Http\Controllers\systems\lls_whip\lls\both;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\EstablishmentStoreRequest;
use App\Services\lls\EstablishmentService;
use App\Repositories\CustomRepository;
use Carbon\Carbon;


class EstablishmentsController extends Controller
{
    protected $conn;
    protected $establishmentService;
    protected $customRepository;
    protected $establishments_table;
    protected $order_by_asc = 'asc';
    protected $order_by_key = 'establishment_code';
    public function __construct(EstablishmentService $establishmentService, CustomRepository $customRepository){
        $this->establishmentService = $establishmentService;
        $this->customRepository     = $customRepository;
        $this->conn                 = config('custom_config.database.lls_whip');
        $this->establishments_table = 'establishments';
    }
    public function add_new_establishments(){

        $data['title'] = 'Add New Establishment';
        $data['barangay'] = config('custom_config.barangay');
        return view('systems.lls_whip.lls.both.establishments.add_new.add_new')->with($data);
    }


    public function establishments_list(){

        $data['title'] = 'Establishment List';
        return view('systems.lls_whip.lls.both.establishments.lists.lists')->with($data);
    }


    public function establishments_view_information($id){
        $row                            = $this->customRepository->q_get_where($this->conn,array('establishment_id' => $id),$this->establishments_table)->first();
        $data['row']                    = $row;
        $data['year_now']               = Carbon::now()->format('Y');
        $data['barangay']               = config('custom_config.barangay');
        $data['title']                  = $row->establishment_name;
        // $data['level_of_employment']    = config('app.level_of_employment');
        // $data['nature_of_employment']   = config('app.lls_nature_of_employment');
        // $data['positions']              =  $this->customRepository->q_get_where_order($this->conn,$this->position_table,array('type' => 'lls'),'position','asc')->get();
        // $data['employment_status']      = $this->customRepository->q_get_order($this->conn,$this->employment_status_table,'status','asc')->get();
        return view('systems.lls_whip.lls.both.establishments.view.view')->with($data);
    }


    

    //CREATE
    public function insert_establishment(EstablishmentStoreRequest $request){

        $validatedData = $request->validated();
        $resp = $this->establishmentService->registerES($validatedData);

        if ($resp) {
            return response()->json([
                'message' => 'Establishment Added Successfully', 
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
    public function get_all_establishment(){
        $es = $this->customRepository->q_get_order($this->conn,$this->establishments_table,$this->order_by_key,$this->order_by_asc)->get();
        $items = [];
        foreach ($es as $row) {
           $items[] = array(
                    'establishment_id'          => $row->establishment_id,
                    'establishment_code'        => $row->establishment_code,
                    'establishment_name'        => $row->establishment_name,
                    'contact_number'            => $row->contact_number,
                    'telephone_number'          => $row->telephone_number,
                    'full_address'              => $this->establishmentService->establishment_full_address($row),
                    'email_address'             => $row->email_address,
                    'authorized_personnel'      => $row->authorized_personnel,
                    'position'                  => $row->position,
                    'status'                    => $row->status,
                    
           );
        }

        return response()->json($items);
    }
    //UPDATE
    public function update_establishment(Request $request){

        $resp = $this->establishmentService->Update_Establishment($request);
        if ($resp) {
            // Registration successful
            return response()->json([
                'message' => 'Establishment Updated Successfully', 
                'response' => true
            ], 201);
        }else {
            return response()->json([
                'message' => 'Something Wrong/No Changes Applied', 
                'response' => false
            ], 422);
        }

    }
    //DELETE
    public function delete_establishment(Request $request)
    {

        $id = $request->input('id')['id'];
        if (is_array($id)) {
            foreach ($id as $row) {
               $where = array('establishment_id' => $row);
               $this->customRepository->delete_item($this->conn,$this->establishments_table,$where);
            }

            $data = array('message' => 'Deleted Succesfully', 'response' => true);
        } else {
            $data = array('message' => 'Error', 'response' => false);
        }



        return response()->json($data);
    }


}
