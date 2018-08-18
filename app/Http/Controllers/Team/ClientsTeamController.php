<?php

namespace App\Http\Controllers\Team;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Client;

use App\Http\Requests\ClientSave;

class ClientsTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();
        return view('layouts.team.clients', [ 'clients' => $clients ]);
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
    public function store(ClientSave $request)
    {
        $active = $request->input('active');
		if (!$active) {
			$active = 0;
		}
		
        $client = Client::create([
            'name' => $request->name,
            'active' => $active,
        ]);
        
        if ($client) {
	        return redirect()->route('admin:projects:list')->with('success', 'Client „'.$client->name.'“ was created!');
        }
        
		return redirect()->route('admin:projects:list')->with(['error'=> 'Could not create client!','form'=>'project']);
        
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
        $client = Client::find($id);
        if ($client) {   
            return view('layouts.team.client_edit',['client'=>$client]);
        }
        return redirect()->route('admin:clients:list')->with('error', 'No such client!');
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
        $client = Client::find($id);
        $active = $request->input('active');
        if (!$active) {
            $active = 0;
        }
        $client->name = $request->input('name');
        $client->active = $active;
        $client->save();

        if ($client) {    
            return redirect()->route('admin:projects:list')->with('success', 'Client „'.$client->name.'“ was updated!');
        } 
        
        return redirect()->route('admin:projects:list')->with('error', 'Could not update client!');
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
    
    /**
     * AJAX - get client by name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function ajaxGetByName(Request $request)
    {
    
        $results = [];
    	
        $term = $request->input('term');
        		
		$clients = Client::where('name','like','%'.$term.'%')->take(5)->get();

		foreach ($clients as $client) {
		
		    $results[] = [ 'id' => $client->id, 'value' => $client->name, 'name' => $client->name ];
		
		}

	    return response()->json($results);
    
    }    
}
