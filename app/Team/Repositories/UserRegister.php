<?php

namespace App\Team\Repositories;

use App\User;
use App\Models\Employee;
use App\Models\Vacation;
use App\Events\RegisteredByOther;
use Illuminate\Auth\Events\Registered;
use Carbon\Carbon;
use Session;



class UserRegister {

	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

	public static function register($request,$adminRegistrar=false) {
        

		if ($adminRegistrar) {
			//$password = bin2hex(openssl_random_pseudo_bytes(4));
			$password = 'password';
		} else {
			$password = $request->input('password');
		}
		
		$data = [
			'email' => $request->input('email'),
			'password' => $password,
			'firstname' => $request->input('firstname'),
			'lastname' => $request->input('lastname'),
			'admin' => $request->input('admin'),
		];
		
		if ($adminRegistrar) {
			$data['start'] = $request->input('start');
			$data['vacations_contract'] = $request->input('vacations_contract');
			$data['vacations_extra'] = $request->input('vacations_extra');
		}
		
		$user = self::create($data,$adminRegistrar);
		
		return $user;
    	
	}
	
	
	public static function create(array $data, $adminRegistrar = false) {
		
		if (!$adminRegistrar OR empty($data['admin'])) {
			$data['admin'] = 0;
		}
		
		$user = User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'admin' => $data['admin'],    
        ]);
        
        if ($user) {
        
        	if ($adminRegistrar) {

	        	//event(new RegisteredByOther($user, $data['password']));
	        	
                $employee = Employee::create([
                    'start' => $data['start'],
                    'user_id' =>$user->id,
                    'vacations_contract' => $data['vacations_contract'],
                    'vacations_extra' => $data['vacations_extra'],
                ]);           

        	} else {
	        	
	        	//event(new Registered($user));        		
	        	
                $employee = Employee::create([
                    'user_id' =>$user->id,
                ]);
        		
        	}
        	
        	// add referrals	        
			return $user;
    	} 
    	
    	return false;
		
	}
	public static function createAdmin(array $data)
	{
		$isThereAdmin = new User;
		$check = $isThereAdmin->where('admin',true)->get();
		if ($check->first() !== null){
			$admin = false;
		}else{
			$admin = true;
		}

		$user = User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'admin' => $admin,    
		]);

		$employee = Employee::create([
			'start' => date('Y-m-d'),
			'user_id' =>$user->id,
			'vacations_contract' => 20,
			'vacations_extra' => 5,
		]); 
		
		return $user;
	}
}
