<?php

namespace App\Http\Controllers\systems\lls_whip\lls\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    
    public function index(){

        $data['title']              = 'User Dashboard';
        return view('systems.lls_whip.lls.user.pages.dashboard.dashboard')->with($data);
    }
}
