<?php

namespace App\Http\Controllers\Team;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Project;
use App\Models\Client;
use App\User;
use DB;

use App\Http\Requests\ProjectSave;

class ProjectsTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//      $projects = Project::all();
        $clients = Client::activeFirst()->with(['projects'])->get();

        return view('layouts.team.projects', [ 'clients' => $clients ]);
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
    public function store(ProjectSave $request)
    {
        
        $active = $request->input('active');
		if (!$active) {
			$active = 0;
		}
        $color = $request->input('color');
        if (!$color) {
            $color = 'acb6e5';
        }
		
        $project = Project::create([
            'name' => $request->name,
            'client_id' => $request->client_id,
            'active' => $active,
            'color' => $color,
            'budgeted' => $request->input('budgeted'),
            'deadline' => $request->input('deadline')
        ]);
        
        if ($project) {
	        return redirect()->route('admin:projects:list')->with('success', 'Project „'.$project->name.'“ was created!');
        }
        
		return redirect()->route('admin:projects:list')->with(['error'=> 'Could not create project!','form'=>'project']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $users = User::all();
        $project = Project::with('calendars', 'calendars.user', 'client')->find($id);
        if($project) {
            return view('layouts.team.projects_stats', [ 'project' => $project, 'users' =>$users ]);
        }
        return redirect()->route('admin:clients:list')->with('error', 'No such project!');
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $project = Project::find($id);
       if ($project) {   
            return view('layouts.team.project_edit',['project'=>$project]);
        }
        return redirect()->route('admin:clients:list')->with('error', 'No such project!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $project = Project::find($id);
        $active = $request->input('active');
        if (!$active) {
            $active = 0;
        }

        $color = $request->input('color');
        if (!$color) {
            $color = 'acb6e5';
        }
        $project->name = $request->input('name');
        $project->budgeted = $request->input('budgeted');
        $project->deadline = $request->input('deadline');
        $project->color = $color;
        $project->active = $active;
        $project->save();

        if ($project) {    
            return redirect()->route('admin:projects:list')->with('success', 'Project „'.$project->name.'“ was updated!');
        } 
        
        return redirect()->route('admin:projects:list')->with('error', 'Could not update project!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
