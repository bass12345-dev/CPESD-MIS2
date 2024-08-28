<?php

namespace App\Http\Controllers\systems\rfa\user;

use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use App\Repositories\rfa\user\RFAQuery;
use App\Services\CustomService;
use App\Services\user\UserService;
use Illuminate\Http\Request;

class CompletedController extends Controller
{

    protected $conn;
    protected $customRepository;
    protected $customService;
    protected $userService;
    protected $rFAQuery;

    public function __construct(CustomRepository $customRepository, RFAQuery $rFAQuery, CustomService $customService, UserService $userService)
    {

        $this->customRepository = $customRepository;
        $this->customService = $customService;
        $this->userService  = $userService;
        $this->conn = config('custom_config.database.pmas');
        $this->rFAQuery = $rFAQuery;
    }
    public function index()
    {
        $data['title'] = 'Completed Transactions';
        return view('systems.rfa.user.pages.completed.completed')->with($data);
    }


    public function get_user_completed_rfa()
    {


        $items = $this->rFAQuery->QueryUserCompletedRFA();
        $data = [];

        foreach ($items as $row) {
            $client = $this->customRepository->q_get_where($this->conn,array('rfa_client_id' => $row->client_id),'rfa_clients')->first();
            $data[] = array(

                'rfa_id'                => $row->rfa_id,
                'name'                  => $this->userService->user_full_name($client),
                'type_of_request_name'  => $row->type_of_request_name,
                'type_of_transaction'   => $row->type_of_transaction,
                'address'               => $client->purok == 0 ? $client->barangay : 'Purok ' . $client->purok . ' ' . $client->barangay,
                'ref_number'            => $this->customService->ref_number($row),
                'created_by'            => $this->userService->user_full_name($row),
            );

        }
        return response()->json($data);

    }






}
