<?php

namespace App\Http\Controllers\systems\dts\user;

use App\Http\Controllers\Controller;
use App\Repositories\dts\DtsQuery;
use App\Services\dts\user\DocumentService;
use App\Services\dts\user\ActionLogsService;
use Carbon\Carbon;

class ActionLogsController extends Controller
{
    protected $dtsQuery;
    protected $documentService;
    protected $actionLogService;
    private $user_type                  = 'user';
    public function __construct(DtsQuery $dtsQuery, DocumentService $documentService, ActionLogsService $actionLogService)
    {
        $this->dtsQuery = $dtsQuery;
        $this->documentService = $documentService;
        $this->actionLogService = $actionLogService;
    }
    public function index(){
        $data['title']          = 'Action Logs';
        $data['current']            = Carbon::now()->year.'-'.Carbon::now()->month;
        return view('systems.dts.user.pages.action_logs.action_logs')->with($data);
    }

    public function get_action_logs(){

        $month = '';
        $year = '';
        if(isset($_GET['date'])){
            $month =   date('m', strtotime($_GET['date']));
            $year =   date('Y', strtotime($_GET['date']));
        }

        $data = $this->actionLogService->UserActionLogs($month, $year);
        return response()->json($data);

       
    }


}
