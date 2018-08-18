<?php

namespace App\Http\Controllers\Team;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Project;
use App\User;
use App\Models\Calendar;

use App\Team\Helpers\ColorsHelper;

use App\Http\Requests\CalendarSave;

class CalendarTeamController extends Controller
{
    /**
     * Show the application dashboard for team admin
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {   
	    
	    $length = 5;
	    
	    // get all active projects
        $projects = Project::isActive()->get();
        // get all active team members
        $users = User::isTeam()->get();
		
		// build days
		$date = new \DateTime('today');
        if ($length == 5 OR $length == 7) {
	        $date->modify('Monday this week');
	    }
	    $start = $date->format('Y-m-d');
        $days = [];
        for($d=1;$d<=$length;$d++) {
	        $days[] = [
		        'date' => $date->format('Y-m-d'),
		        'weekday' => $date->format('l'),
		        'day' => $date->format('d/m'),
	        ];
	        $date->modify('+1 day');
        }
        $end = $date->format('Y-m-d');
        $col=new ColorsHelper();
        
        return view('layouts.team.planner', [ 
	        'length' => $length,
	        'days' => $days,
        	'projects' => $projects, 
        	'users' => $users,
        ]);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CalendarSave $request)
    {
        $result = [
        	'result' => false,
        	'id' => null,
        ];
        
        $length = $request->input('length');
        // check length of other projects?
        
        $project = Project::find($request->project_id);
		if ($project) {
			
			 $task = Calendar::create([
	            'date' => $request->date,
	            'user_id' => $request->user_id,
	            'client_id' => $project->client_id,
	            'project_id' => $project->id,            
	            'length' => $length,
	            'away' => null,
	        ]);
	        
	        if ($task) {
		        $result = [
		        	'result' => true,
		        	'id' => $task->id,
		        ];	        
	        }
			
		}
        
		return response()->json($result);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CalendarSave $request, $id)
    {
        $result = [
        	'result' => false,
        	'id' => null,
        ];
        
        $calendar = Calendar::find($id);
        
        if ($calendar) {
	        
	        $calendar->length = $request->length;
// 	        $calendar->comment = $request->comment;
	        $calendar->save();
	        
	        $result = [
	        	'result' => true,
	        	'id' => $calendar->id,
	        ];	        

        }
        
		return response()->json($result);
		
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = [
        	'result' => false,
        	'id' => null,
        ];
        
        $calendar = Calendar::find($id);
        
        if ($calendar) {
	        
	        $result = [
	        	'result' => true,
	        	'id' => $calendar->id,
	        ];	        
	        $calendar->delete();

        }
        
		return response()->json($result);
    }
        
}
