<?php

namespace App\Http\Controllers\systems\rfa\admin;
use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use App\Repositories\rfa\admin\AdminRFAQuery;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    protected $conn;
    protected $customRepository;
    protected $rFAQuery;

    public function __construct(CustomRepository $customRepository, AdminRFAQuery $rFAQuery)
    {

        $this->customRepository = $customRepository;
        $this->conn = config('custom_config.database.pmas');
        $this->rFAQuery = $rFAQuery;
    }
    public function index()
    {
        $data['title'] = 'Client';
        $data['barangay'] = config('custom_config.barangay');
        $data['employment_status'] = config('custom_config.employment_status');
        return view('systems.rfa.admin.pages.clients.clients')->with($data);
    }


    public function load_gender_client_by_month(Request $request)
    {

        $year = $request->input('year1');
        $months = array();
        $male = array();
        $female = array();

        for ($m = 1; $m <= 12; $m++) {

            $total_male = $this->rFAQuery->QueryGenderByMonthAndYear($m, $year, 'male');
            array_push($male, $total_male);


            $total_female = $this->rFAQuery->QueryGenderByMonthAndYear($m, $year, 'female');
            array_push($female, $total_female);

            $month = date('M', mktime(0, 0, 0, $m, 1));
            array_push($months, $month);
        }
        $data['label'] = $months;
        $data['male'] = $male;
        $data['female'] = $female;
        return response()->json($data);

    }


    public function get_by_gender_total()
    {
        $total = array();
        $gender = ['male', 'female'];
        foreach ($gender as $row) {

            $res = $this->customRepository->q_get_where($this->conn, array('gender' => $row), 'rfa_clients')->count();
            array_push($total, $res);
        }

        $data['label'] = $gender;
        $data['total'] = $total;
        $data['color'] = ['rgb(41,134,204)', 'rgb(201,0,118)'];
        return response()->json($data);
    }



    public function get_clients()
    {

        $item = $this->customRepository->q_get_order($this->conn, 'rfa_clients', 'first_name', 'asc')->get();
        foreach ($item as $row) {

            $data[] = array(

                'rfa_client_id' => $row->rfa_client_id,
                'first_name' => $row->first_name,
                'middle_name' => $row->middle_name,
                'last_name' => $row->last_name,
                'extension' => $row->extension,
                'address' => $row->purok == 0 ? $row->barangay : 'Purok ' . $row->purok . ' ' . $row->barangay,
                'contact_number' => $row->contact_number,
                'age' => $row->age,
                'employment_status' => $row->employment_status,
                'purok' => $row->purok,
                'barangay' => $row->barangay,
                'full_name' => $row->first_name . ' ' . $row->middle_name . ' ' . $row->last_name . ' ' . $row->extension,
                'gender' => $row->gender == null ? '' : $row->gender

            );
        }

        return response()->json($data);

    }

    public function update_client(Request $request)
    {
        $data = array(

            'first_name'            => $request->input('update_first_name'),
            'middle_name'           => ($request->input('update_middle_name') == '') ? '' : $request->input('update_middle_name'),
            'last_name'             => $request->input('update_last_name'),
            'extension'             => ($request->input('update_extension') == '') ? '' : $request->input('update_extension'),
            'purok'                 => $request->input('update_purok'),
            'barangay'              => $request->input('update_barangay'),
            'contact_number'        => $request->input('update_contact_number'),
            'age'                   => $request->input('update_age'),
            'employment_status'     => $request->input('update_employment_status'),
            'gender'                => $request->input('gender'),
        );
        $where = array('rfa_client_id' => $request->input('client_id_'));
        $update = $this->customRepository->update_item($this->conn,'rfa_clients', $where, $data);

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

    public function delete_client(Request $request){
        $where1 = array('rfa_client_id' => $request->input('id'));
        $where2 = array('client_id' => $request->input('id'));
        $check = $this->customRepository->q_get_where($this->conn,$where2,'rfa_transactions')->count(); 
        if ($check > 0) {
             $data = array(
                    'message' => 'This data is used in other operations',
                    'response' => false
                    );
            
        }else {
             $result = $this->customRepository->delete_item($this->conn,'rfa_clients',$where1);
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
