<?php

namespace App\Http\Middleware\Roles\Language;

use Closure;
use App\Http\Controllers\RoleManageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Create
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (config('role_manage.Language.Create')){ //Create
            return $next($request);
        }else{
            Session::flash('error', 'You Can Not Perform This Action.Please Contact Your It Officer');
            return redirect()->back();
        }
    }
}
