<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password', 'admin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    /**
    * Casting
    *
    * @var array
    */
    protected $casts = [
	    'admin' => 'boolean',
	]; 
	
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
	public $timestamps = true;
	
	/**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 20;
	
	public function getFullNameAttribute() {
		$name = '';
		if (!empty($this->firstname)) {
			$name .= $this->firstname;
		}
		if (!empty($this->firstname)) {
			if (!empty($name)) {
				$name .= ' ';
			}
			$name .= $this->lastname;
		}
		return $name;
	}
	
    /**
    * Get the user user employee.
    */
    public function employee()
    {
        return $this->hasOne('App\Models\Employee');
    }

    /**
    * Get the user user vacations.
    */
    public function vacations()
    {
        return $this->hasMany('App\Models\Vacation');
    }
    

	/**
    * Get the user calendar.
    */
    public function calendars()
    {
        return $this->hasMany('App\Models\Calendar');
    }
    
    /**
     * Get team members, ordered by first name
     *
     */
    public function scopeIsTeam($query)
    {
        return $query->orderBy('firstname','asc');
    }

    public function isAdmin()
    {
        return $this->admin; 
    }
        
}
