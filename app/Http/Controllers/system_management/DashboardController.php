<?php

namespace App\Http\Controllers\system_management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $data['title']  = 'System Management';
        return view('system_management.contents.dashboard.dashboard')->with($data);
    }
}
