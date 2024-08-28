<?php

namespace App\Services\dts\receiver;

use App\Repositories\CustomRepository;
use App\Repositories\dts\AdminDtsQuery;
use App\Repositories\dts\DtsQuery;
use App\Services\user\ActionLogService;
use App\Services\CustomService;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReceiverService
{

    protected $conn;
    protected $conn_user;
    protected $customRepository;
    protected $dtsQuery;
    protected $adminDtsQuery;

    public function __construct(CustomRepository $customRepository, DtsQuery $dtsQuery, AdminDtsQuery $adminDtsQuery)
    {
        $this->conn                 = config('custom_config.database.dts');
        $this->conn_user            = config('custom_config.database.users');
        $this->customRepository     = $customRepository;
        $this->dtsQuery             = $dtsQuery;
        $this->adminDtsQuery        = $adminDtsQuery;

    }

    public function countmydoc_dash(){

        $id = session('user_id');
        $date_now = Carbon::now()->format('Y-m-d');
        $data = array(
                'count_documents'       => $this->customRepository->q_get($this->conn,'documents')->count(),
                'incoming'              => $this->customRepository->q_get_where($this->conn,array('user2' => $id,'received_status' => NULL, 'status' => 'torec', 'release_status' => NULL, 'to_receiver' => 'yes'),'history')->count(),
                'received'              => $this->customRepository->q_get_where($this->conn,array('user2' => $id,'received_status' => 1, 'status' => 'received', 'release_status' => NULL, 'to_receiver' => 'yes'),'history')->count(),
                'added_today'           => $this->dtsQuery->added_document_date_now($date_now),
                'completed_today'       => $this->adminDtsQuery->completed_document_date_now($date_now),
                'latest'                => $this->adminDtsQuery->get_all_documents_with_limit_completed('10'),
    
        );

        return $data;
    }



 
}
