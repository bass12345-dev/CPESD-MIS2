<?php

namespace App\Http\Controllers\systems\dts\user;

use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use App\Repositories\dts\DtsQuery;
use App\Services\CustomService;
use App\Services\dts\user\DocumentService;
use App\Services\user\UserService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class AddDocumentController extends Controller
{
   
    protected $conn;
    protected $conn_user;
    protected $customRepository;
    protected $dashboardService;
    protected $customService;
    protected $documentService;
    protected $dtsQuery;
    protected $user_table;
    protected $office_table;
    protected $document_types_table;
    protected $documents_table;
    protected $user_type;
    protected $userService;
    public function __construct(CustomRepository $customRepository, DtsQuery $dtsQuery, CustomService $customService,DocumentService $documentService,UserService $userService){
        $this->conn                 = config('custom_config.database.dts');
        $this->conn_user            = config('custom_config.database.users');
        $this->customRepository     = $customRepository;
        $this->customService        = $customService;
        $this->documentService      = $documentService;
        $this->userService          = $userService;
        $this->dtsQuery             = $dtsQuery;
        $this->user_table           = 'users';
        $this->office_table         = 'offices';
        $this->document_types_table = 'document_types';
        $this->documents_table      = 'documents';
        $this->user_type            = 'user';
        
     
    }
    public function index(){
        $data['title']              = 'Add Document';
        $data['user_data']          = $this->customRepository->q_get_where($this->conn_user,array('user_id' => session('user_id')),$this->user_table)->first();
        $data['offices']            = $this->customRepository->q_get_order($this->conn,$this->office_table,'office','asc')->get();
        $data['document_types']     = $this->customRepository->q_get_order($this->conn,$this->document_types_table,'type_name','asc')->get(); 
        return view('systems.dts.user.pages.add_document.add_document')->with($data);
    }

    // CREATE
    public function insert_document(Request $request)
    {
        $data = $this->documentService->add_document_process($request,$this->user_type);
        return response()->json($data);
    }
    // READ
    public function get_documents_limit(){
        $items = $this->dtsQuery->get_all_documents_with_limit(10);
        $i = 1;
        $data = [];
        foreach ($items as $value => $key) {
            $data[] = array(
                'number'            => $i++,
                'document_name'     => $key->document_name,
                'document_number'   => $key->tracking_number,
                'name'              => $this->userService->user_full_name($key)
                
            );
        }      
        return response()->json($data);
    }
    
    // UPDATE
    // DELETE





    public function get_last_tracking_number(){

        #define tracking number variable
        $tracking_number = '';
        #count documents added in database
        $verify = $this->customRepository->q_get($this->conn,$this->documents_table)->count();
        #get current year
        $current_year = Carbon::now()->format('Y');
        #ymd format = Year Month Day
        $ymd_format = Carbon::now()->format('Ymd');

        #CONDITION

        #check if there is document added in database
        if($verify) {
            #get last added in database
            $last_created = date('Y', strtotime( $this->customRepository->q_get_order($this->conn,$this->documents_table,'created','desc')->first()->created));
                
             #current year is greater than the last year added
            if($current_year > $last_created )
                {      
                    #set tracking number to 001
                     $tracking_number = $ymd_format.'001';
                #current year is less than the last year added
                }else if ($current_year < $last_created) {
                    #get last created and then add 1
                    $tracking_number = DB::connection($this->conn)->table($this->documents_table)
                                        ->whereRaw("YEAR(documents.created) = '".Carbon::now()->format('Y-m-d')."' ")
                                        ->orderBy('created', 'desc')
                                        ->first()->tracking_number +  1;
                #current year is equal in last year added                       
                }else if (Carbon::now()->format('Y') === $last_created){
                    #get last three digits
                    $last_digits = $this->last_digits() + 1;
                    $tracking_number = $ymd_format.$this->customService->put_zeros($last_digits);
                }
        }else {
            $tracking_number = $ymd_format.'001';
        }
        return $tracking_number;
    }



    function last_digits() { 

    $number = DB::connection($this->conn)->table($this->documents_table)
                    ->whereRaw("YEAR(documents.created) = '".Carbon::now()
                    ->format('Y')."' ")
                    ->orderBy('created', 'desc')
                    ->first()
                    ->tracking_number;
        //get digits after year month date format
        $number = substr($number,8,8);
        return $number;
    
        
    } 

    
}
