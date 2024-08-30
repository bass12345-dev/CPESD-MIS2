<?php

namespace App\Http\Controllers\systems\lls_whip\lls\both;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompliantController extends Controller
{
    public function index()
    {
        $data['title'] = 'Compliant Report';
        return view('systems.lls_whip.lls.both.reports.compliant_reports.compliant_reports')->with($data);
    }

   

}
