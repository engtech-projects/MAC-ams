<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\URL;

class RedirectIfNoAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
		$isNumeric = false;
		foreach(explode('/',strtolower($request->path())) as $value)
		{
			if(is_numeric($value))
			{
				$isNumeric = true;
			}
		}
		$user = Auth::user();
		foreach($user->accessibilities as $accessibility){
			if(strtolower($accessibility['subModuleList']['route']) == strtolower($request->path()) || $isNumeric)
			{
				return $next($request);
			}
		}
		if ($request->path() == '/') {
			return $next($request);
		}
		abort(404, 'You have no access in thins function try contact admin to add this function in your access list');
    }
}
