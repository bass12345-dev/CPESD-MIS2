<?php

namespace App\Http\Controllers\systems\rfa\admin;
use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use App\Repositories\rfa\admin\AdminRFAQuery;
use App\Services\CustomService;
use App\Services\user\UserService;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    protected $conn;
    protected $customRepository;
    protected $customService;
    protected $userService;
    protected $rFAQuery;

    public function __construct(CustomRepository $customRepository, AdminRFAQuery $rFAQuery, CustomService $customService, UserService $userService)
    {

        $this->customRepository = $customRepository;
        $this->customService    = $customService;
        $this->userService      = $userService;
        $this->conn = config('custom_config.database.pmas');
        $this->rFAQuery = $rFAQuery;
    }
    public function index()
    {
        $data['title'] = 'RFA Report';
        
        return view('systems.rfa.admin.pages.report.report')->with($data);
    }

    public function generate_rfa_report(Request $request){
        $date_filter                        = $request->input('date_filter');
        $start                              = explode(" - ",$date_filter)[0];
        $end                                = explode(" - ",$date_filter)[1];
        $data                               = [];
        $filter_data                        = array(
                    'start_date'        => date('Y-m-d', strtotime($start)),
                    'end_date'          => date('Y-m-d', strtotime($end)),
            );

        $items                              = $this->rFAQuery->QueryRFATransactionDateFilter($filter_data);


        foreach ($items as $row ) {


                $data[]                     = array(

                        'rfa_id'                => $row->rfa_id ,
                        'name'                  => $row->client_first_name.' '.$row->client_middle_name.' '.$row->client_last_name.' '.$row->client_extension,
                        'type_of_request_name'  => $row->type_of_request_name,
                        'type_of_transaction'   => $row->type_of_transaction,
                        'address'               => $row->client_purok == 0 ? $row->client_barangay : 'Purok '.$row->client_purok.' '.$row->client_barangay,
                         'ref_number'           => $this->customService->ref_number($row),
                         'created_by'           => $this->userService->user_full_name($row)



                       
                );

        


    }

     echo json_encode($data);
    }



}
