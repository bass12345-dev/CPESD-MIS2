<?php

namespace App\Http\Controllers\systems\lls_whip\lls\both;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PositionsController extends Controller
{
    public function index(){
        $data['title'] = 'Position List';
        return view('systems.lls_whip.lls.both.positions.lists')->with($data);
    }
}
