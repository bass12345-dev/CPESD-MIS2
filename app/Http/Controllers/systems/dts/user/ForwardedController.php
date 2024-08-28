<?php

namespace App\Http\Controllers\systems\dts\user;

use App\Http\Controllers\Controller;
use App\Repositories\dts\DtsQuery;
use App\Services\dts\user\DocumentService;
use App\Repositories\CustomRepository;
use Illuminate\Http\Request;
use App\Services\user\ActionLogService;
use App\Services\user\UserService;

class ForwardedController extends Controller
{
    protected $dtsQuery;
    protected $documentService;
    private   $user_type                  = 'user';
    protected $customRepository;
    protected $actionLogService;
    protected $userService;
    protected $conn;
    protected $conn_user;
    public function __construct(DtsQuery $dtsQuery, DocumentService $documentService, CustomRepository $customRepository, ActionLogService $actionLogService, UserService $userService)
    {
        $this->conn                 = config('custom_config.database.dts');
        $this->conn_user            = config('custom_config.database.users');
        $this->dtsQuery             = $dtsQuery;
        $this->documentService      = $documentService;
        $this->customRepository     = $customRepository;
        $this->actionLogService     = $actionLogService;
        $this->userService          = $userService;
    }
    public function index()
    {
        $data['title']              = 'Forwarded Documents';
        $data['users']              = $this->customRepository->q_get_where($this->conn_user, array('user_status' => 'active'), 'users')->get();
        return view('systems.dts.user.pages.forwarded.forwarded')->with($data);
    }




    public function get_forwarded_documents()
    {

        $data = [];
        $i = 1;
        $rows =  $this->dtsQuery->QueryForwardedDocuments();
        foreach ($rows as $key) {

            $data[] = array(
                'number'            => $i++,
                'tracking_number'   => $key->tracking_number,
                'history_id'        => $key->history_id,
                'document_name'     => $key->document_name,
                'type_name'         => $key->type_name,
                'released_date'     => date('M d Y - h:i a', strtotime($key->release_date)),
                'forward_to_id'     => $key->user_id,
                'forwarded_to'      => $key->final_receiver == 'yes' ? '<span class="text-danger">To Final Receiver</span>' : $this->userService->user_full_name($key),
                'document_id'       => $key->document_id,
                'remarks'           => $key->remarks,
            );
        }

        return response()->json($data);
    }

    public function update_remarks(Request $request)
    {

        $id         = $request->input('history_id');
        $remarks    = $request->input('remarks_update');
        $document_id    = $request->input('remarks_document_id');
        $update_release = $this->customRepository->update_item($this->conn, 'history', array('history_id' => $id), array('remarks' => $remarks));
        if ($update_release) {
            $item = $this->documentService->document_data(array('document_id' => $document_id));
            $this->actionLogService->dts_add_action('Updated Remarks to Document No. ' . $item->tracking_number, 'user', $document_id);
            $data = array('message' => 'Remarks Updated Successfully', 'response' => true);
        } else {
            $data = array('message' => 'Something Wrong | Remarks is not updated', 'response' => false);
        }

        return response()->json($data);
    }
    public function update_forwarded(Request $request)
    {
       
        $id = $request->input('history_id');
        $tracking_number = $request->input('tracking_number');
        $forward_to = $request->input('forward') == 'fr' ? $this->userService->get_receiver()->user_id : $request->input('forward');
        $is_yes = $request->input('forward') == 'fr' ? 'yes' : 'no';

       

        $r = $this->customRepository->q_get_where($this->conn, array('tracking_number' => $tracking_number),'documents')->first();
        $user_row = $this->customRepository->q_get_where($this->conn_user, array('user_id' => $forward_to),'users')->first();
        $update_release = $this->customRepository->update_item($this->conn,'history', array('history_id' => $id), array('user2' => $forward_to, 'to_receiver' => $is_yes));
        if ($update_release) {
            $this->actionLogService->dts_add_action(
                'Update Forwarded Document No. ' . $tracking_number . ' to ' . $this->userService->user_full_name($user_row),
                'user',
                $r->document_id
            );
            $data = array('message' => 'Updated Successfully', 'response' => true);
        } else {
            $data = array('message' => 'Something Wrong', 'response' => false);
        }

        return response()->json($data);
    }
}
