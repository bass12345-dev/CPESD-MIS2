<?php

namespace App\Services\watchlisted\user;

use App\Repositories\CustomRepository;
use App\Services\CustomService;

class DashboardService
{

    protected $conn;
    protected $customRepository;
 

    public function __construct(CustomRepository $customRepository)
    {
        $this->conn = config('custom_config.database.dts');
        $this->customRepository = $customRepository;
    }

    public function per_barangay(){
        $active     = array();
        $barangay   = config('custom_config.barangay');

        foreach ($barangay as $row) {
            $count = $this->customRepository->q_get_where($this->conn,array('status' => 'active', 'address' => $row),'persons')->count();
            array_push($active, $row.'  <span class="text-primary">('.$count.')</span>');
        }
        return $active;
    }

 
}
