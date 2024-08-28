<?php

namespace App\Http\Controllers\systems\watchlisted\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Repositories\watchlisted\PersonQuery;
use App\Services\user\UserService;
use App\Services\watchlisted\user\DashboardService;
use Carbon\Carbon;

class ViewController extends Controller
{

    protected $conn;
    protected $customRepository;
    protected $dashboardService;
    protected $personQuery;
    protected $userService;
    public function __construct(CustomRepository $customRepository, DashboardService $dashboardService, PersonQuery $personQuery, UserService $userService)
    {
        $this->conn                 = config('custom_config.database.dts');
        $this->customRepository     = $customRepository;
        $this->dashboardService     = $dashboardService;
        $this->userService          = $userService;
        $this->personQuery          = $personQuery;
    }
    public function index($id)
    {
        $count = $this->customRepository->q_get_where($this->conn, array('person_id' => $id), 'persons');
        if ($count->count() > 0) {
            $data['title']                      = $this->userService->user_full_name($count->first());
            $data['person_data']                = $this->personQuery->QueryPersonData($id);
            return view('systems.watchlisted.user.pages.view.view')->with($data);
        } else {
            echo '404';
        }
    }
}
