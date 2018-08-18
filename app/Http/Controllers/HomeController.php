<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use App\User;
use App\Models\Project;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {   
        //return redirect()->route('admin:dashboard');
	    // if ( Session::get('team_admin') ) {
        if (Auth::user()->isAdmin()){
		    return redirect()->route('admin:dashboard');
		}
		
        $projects = Project::isActive()->get();
        $user = Auth::user();

        return view('home', [ 
        	'projects' => $projects, 
        	'user' => $user,
        ]);
        
    }
}
