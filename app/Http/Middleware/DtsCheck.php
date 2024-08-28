<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\CustomRepository;

class DtsCheck
{
    protected $conn;
    protected $customRepository;

    public function __construct(CustomRepository $customRepository,)
    {
        $this->customRepository = $customRepository;
        $this->conn = config('custom_config.database.users');
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $count = $this->customRepository->q_get_where($this->conn,array('system_authorized' => 'dts', 'user_id' => session('user_id')),'user_system_authorized')->count();
        if ($count == 0 && session('user_type') == 'user') {
            return redirect('/home');
        }
        return $next($request);
    }
}
