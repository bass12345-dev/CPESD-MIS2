<?php

namespace App\Http\Controllers\systems\pmas\admin;
use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use App\Repositories\pmas\admin\AdminPmasQuery;
use App\Repositories\pmas\user\UserPmasQuery;
use App\Services\CustomService;
use App\Services\pmas\admin\TransactionService;
use App\Services\user\ActionLogService;
use App\Services\user\UserService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PendingController extends Controller
{

    protected $conn;
    protected $customRepository;
    protected $customService;
    protected $userService;

    protected $transactionService;
    protected $adminPmasQuery;
    protected $actionLogService;

    public function __construct(CustomRepository $customRepository, CustomService $customService, AdminPmasQuery $adminPmasQuery, UserPmasQuery $userPmasQuery, TransactionService $transactionService, ActionLogService $actionLogService)
    {

        $this->customRepository = $customRepository;
        $this->customService = $customService;
        $this->adminPmasQuery = $adminPmasQuery;
        $this->transactionService = $transactionService;
        $this->actionLogService = $actionLogService;
        $this->conn = config('custom_config.database.pmas');

    }
    public function index()
    {
        $data['title'] = 'Pending';
        return view('systems.pmas.admin.pages.pending.pending')->with($data);
    }

    public function view_transaction($id)
    {

        $row = $this->customRepository->q_get_where($this->conn, array('transaction_id' => $id), 'transactions');
        if ($row->count()) {
            $row = $row->first();
            $data['title'] = $this->customService->pmas_number($row);
            $data['row'] = $row;
            return view('systems.pmas.admin.pages.view.view')->with($data);
        } else {
            echo '404';
        }

    }

    public function view_remarks(Request $request)
    {
        $data = [];
        $where = array('transaction_id' => $request->input('id'));
        $row = $this->customRepository->q_get_where($this->conn, $where, 'transactions')->first();
        $data['remarks'] = $row->remarks;
        $data['transaction_id'] = $where['transaction_id'];
        return response()->json($data);
    }

    public function add_remarks(Request $request)
    {
        $data = array('remarks' => $request->input('content'), );
        $where = array('transaction_id' => $request->input('id'));
        $update = $this->customRepository->update_item($this->conn, 'transactions', $where, $data);
        if ($update) {

            $item = $this->customRepository->q_get_where($this->conn, $where, 'transactions')->first();
            $this->actionLogService->add_pmas_rfa_action('pmas', $item->transaction_id, 'Added Remarks to PMAS No. ' . $this->customService->pmas_number($item));
            $resp = array('message' => 'PMAS No. ' . $this->customService->pmas_number($item) . ' |  Remarks Added Successfully', 'response' => true);
        } else {
            $resp = array('message' => 'Error', 'response' => false);
        }
        return response()->json($resp);

    }


    public function get_pending_transactions(Request $request)
    {
        $data = '';
        if ($request->input('filter') == 'false') {
            $data = $this->transactionService->filter_false_transactions();
        } else if ($request->input('filter') == 'true') {
            $filter_data = array('start_date' => $request->input('start_date'), 'end_date' => $request->input('end_date'));
            $data = $this->transactionService->filter_true_transactions($filter_data);
        }
        return response()->json($data);
    }

    public function approved(Request $request)
    {
        $data = array(
            'transaction_status'                => 'completed',
            'transaction_date_time_completed'   =>  Carbon::now()->format('Y-m-d H:i:s'),
        );
        $where = array('transaction_id' => $request->input('id'));
        $update = $this->customRepository->update_item($this->conn,'transactions',$where, $data);
        if ($update) {

            $item = $this->customRepository->q_get_where($this->conn, $where, 'transactions')->first();
            $this->actionLogService->add_pmas_rfa_action('pmas', $item->transaction_id, 'Completed PMAS No. ' . $this->customService->pmas_number($item));
            $resp = array('message' => 'PMAS No. ' . $this->customService->pmas_number($item) . ' |  Approved Successfully', 'response' => true);
        } else {
            $resp = array('message' => 'Error', 'response' => false);
        }
        return response()->json($resp);

    }

    public function count_pending_transactions(){
        $where = array('transaction_status' => 'pending');
        $count = $this->customRepository->q_get_where($this->conn, $where, 'transactions')->count();
        return $count;

    }



}
