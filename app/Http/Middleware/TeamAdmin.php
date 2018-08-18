<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;
use App\User;

class TeamAdmin
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
		
		$redirect = true;
		
    	if ( ! Session::get('team_admin') ) {	

			$user_admin = Auth::user()->admin;

		    if (!empty($user_admin)) {
		    	$redirect = false;
			    Session::put('team_admin', true);
		    }
		    
	    } else {
		    $redirect = false;
	    }
	    		
		if ($redirect) {
			return redirect('/')->with('error', 'Oh la la.');
		}
		
        return $next($request);
    }
}
