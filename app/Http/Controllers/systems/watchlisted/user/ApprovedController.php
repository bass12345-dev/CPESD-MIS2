<?php

namespace App\Http\Controllers\systems\watchlisted\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Services\watchlisted\user\DashboardService;
use Carbon\Carbon;
class ApprovedController extends Controller
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
        $data['title']                      = 'Approved';
        return view('systems.watchlisted.user.pages.approved.approved')->with($data);
    }

    public function get_approved_watchlisted(){
        $items       = $this->customRepository->q_get_where_order($this->conn,'persons',array('added_by' => session('user_id'),'status'=>'active'),'created_at','desc')->get();
        $i = 1;
        $data = [];
        foreach ($items as $row) {
            $data[] = array(
                        'name'              => $row->first_name.' '.$row->middle_name.' '.$row->last_name.' '.$row->extension,
                        'age'               => $row->age,
                        'address'           => $row->address,
                        'email'             => $row->email_address,
                        'phone_number'      => $row->phone_number,
                        'person_id'         => $row->person_id,
                        'number'            => $i++
            );
           
        }
        return response()->json($data);
    }
}
