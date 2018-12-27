<?php
namespace App\Http\Middleware;

use Closure;
use App\Models\Admin;

class AdminAuth
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request            
     * @param \Closure $next            
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! Admin::checkIsLogged()) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => - 10001,
                    'message' => '未登陆'
                ]);
            }
            return redirect('admin/admin/login');
        }
        $actionName = $request->route()->getActionMethod();
        $caName = explode('\\', $request->route()->getActionName());
        $controllerName = str_replace('Controller@' . $actionName, '', end($caName));
        if (! Admin::checkPower($controllerName, $actionName)) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => - 10001,
                    'message' => '未登陆'
                ]);
            }
            return redirect('errors/404');
        }
        return $next($request);
    }
}
