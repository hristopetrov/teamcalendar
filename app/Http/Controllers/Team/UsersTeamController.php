<?php

namespace App\Http\Controllers\Team;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Models\Vacation;
use App\Models\Employee;

use App\Http\Requests\UserSave;

use App\Team\Repositories\UserRegister;

class UsersTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('layouts.team.users', [ 'users' => $users ]);
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
    public function store(UserSave $request, UserRegister $registrar) {
	    
		$user = $registrar->register($request,true);
		
	    if ($user) {   
			return redirect()->route('admin:users:list')->with('success', 'User „'.$user->firstname.' '.$user->lastname.'“ was created!');
		} 
		
		return redirect()->route('admin:users:list')->with('error', 'Could not create user!');
		
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with(['employee','calendars'=>function($query){
            $query->whereYear('date','2018');
        }])
        ->find($id);

       $today = new \DateTime();
       $start = new \DateTime($user->employee->start);
       if ($start->format('Y') < $today->format('Y')) {
            $passedMonth = $today->format('m'); 
       } else {
            $passedMonth = $today->format('m') - $start->format('m') + 1;
       }
       $allowedVacation = round(($user->employee->vacations_extra + ( ( $user->employee->vacations_contract / 12 ) * $passedMonth) ),0);

       $totalVacsCurrentYear =  $user->calendars()->notInWorkDays('vacation');
       $totalSickDays = $user->calendars()->notInWorkDays('sick');
       $OtherNotWorkingDays = $user->calendars()->notInWorkDays('other');

        return view('layouts.team.users_stats',[
            'user' =>$user, 
            'allowedVacation' => $allowedVacation,
            'start'=>$start, 
            'vacations'=>$totalVacsCurrentYear,
            'sick' =>$totalSickDays, 
            'other'=>$OtherNotWorkingDays]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        if ($user) {   
            return view('layouts.team.user_edit',['user'=>$user]);
        }
        return redirect()->route('admin:users:list')->with('error', 'No such user!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserSave $request, $id)
    {   
        //dd($request->input('vacations_contract'));
        $user = User::find($id);
        $user->update($request->all());


        // $vacation = Vacation::updateOrCreate([
        //     'user_id' => $id,
        //     'year'=> date('Y')
        // ]);
        $user->employee->start = $request->input('start');
        $user->employee->end = $request->input('end');
        $user->employee->vacations_contract = $request->input('vacations_contract');
        $user->employee->vacations_extra = $request->input('vacations_extra');
        $user->employee->save();

        if ($user) {   
            return redirect()->route('admin:users:list')->with('success', 'User „'.$user->firstname.' '.$user->lastname.'“ was updated!');
        } 
        
        return redirect()->route('admin:users:list')->with('error', 'Could not update user!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      User::find($id)->delete();
      return redirect()->route('admin:users:list');
    }
}
