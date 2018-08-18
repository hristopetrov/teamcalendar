<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\User;
use App\Models\Calendar;

use Session;

use App\Http\Requests\CalendarSaveAway;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($from = 'today',$length = 5, $move = null)
    {
		
		$calendar = [
			'length' => $length,
		];
		
        $date = new \DateTime($from);
        if ($from=='today') {
	        $calendar['today'] = $date->format('Y-m-d');
        } else {
	    	$dateToday = new \DateTime('today');
	    	$calendar['today'] = $dateToday->format('Y-m-d');
        }
        
        if ($length == 5 OR $length == 7) {
	        $week = $date->format('Y-m-d');
	    	switch ($move) {
		    	case 'left':
			        $date->modify('Monday previous week '.$week);
			        break;
		    	case 'right':
			        $date->modify('Monday next week '.$week);
			        break;	
		    	default:
			        $date->modify('Monday this week '.$week);
			        break;			        		        
	    	}
	    } else {
		    switch ($move) {
		    	case 'left':
			        $date->modify('-'.$length.' days');
			        break;
		    	case 'right':
			        $date->modify('+'.$length.' days');
			        break;	
		    	default:
			        break;			        		        
	    	}
	    }
	    
	    $calendar['start'] = $date->format('Y-m-d');
		
		if ( Session::get('team_admin') ) {
	        $calendar['users'] = User::isTeam()->select()->get();
	        $users = $calendar['users']->pluck('id')->toArray();
	    } else {
		    $calendar['users'] = [Auth::user()];
		    $users = $calendar['users'][0]->id;
	    }
	    
        for($d=1;$d<=$length;$d++) {
	        $calendar['calendar'][$date->format('Y-m-d')] = [
		        'date' => $date->format('Y-m-d'),
		        'weekday' => $date->format('l'),
		        'day' => $date->format('d/m'),
		        'tasks' => array_fill_keys($users, []),
	        ];
	        $date->modify('+1 day');
        }
        $calendar['end'] = $date->format('Y-m-d');
           

        $tasks = Calendar::dateRange($calendar['start'],$calendar['end'])
        	->whereIn('user_id', $users)
        	->orderBy('date','asc')
        	->get();
        
        foreach($tasks as $task) {
	        $task_to_add = [
		        'id' => $task->id,
		        'project_id' => $task->project_id,
		        'name' => '',
		        'client_name' => '',
		        'length' => $task->length,
		        'away' => $task->away,
		        'color' => '',
	        ];
	        if ($task->project) {
		        $task_to_add['name'] = $task->project->name;
		        $task_to_add['client_name'] = $task->project->client->name;
		        $task_to_add['color'] = $task->project->color;
	        }
	        $calendar['calendar'][$task['date']]['tasks'][$task['user_id']][] = $task_to_add;
        }

        
        $html = view('layouts.calendar', $calendar)->render();
        
        return response()->json([
	        'start' => $calendar['start'],
	        'end' => $calendar['end'],
	        'calendar' => $calendar['calendar'],
	        'html' => $html,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CalendarSaveAway $request)
    {
        $result = [
        	'result' => false,
        	'id' => null,
        ];
        
        $length = 1;
        // check length of other projects?
        
		
        $task = Calendar::create([
            'date' => $request->date,
            'user_id' => $request->user_id,
            'project_id' => null,
            'client_id' => null,       
            'length' => $length,
            'away' => $request->away,
        ]);
        
        if ($task) {
	        $result = [
	        	'result' => true,
	        	'id' => $task->id,
	        ];	        
        }
        
		return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CalendarSaveAway $request, $id)
    {
        $result = [
        	'result' => false,
        	'id' => null,
        ];
        
        $calendar = Calendar::find($id);
        
        if ($calendar) {
	        
	        $calendar->comment = $request->comment;
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
