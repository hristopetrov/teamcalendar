<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'active',
    ];
    
    /**
    * Casting
    *
    * @var array
    */
    protected $casts = [
	    'active' => 'boolean',
	];    
	
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
	public $timestamps = false;
		
	/**
    * Get the projects for this client.
    */
    public function projects()
    {
        return $this->hasMany('App\Models\Project');
    }
    
    /**
    * Get the tasks for this client.
    */
    public function calendars()
    {
        return $this->hasMany('App\Models\Calendar');
    }
    
    /**
     * Shows active only
     *
     */
    public function scopeIsActive($query)
    {
        return $query->where('active','=',true);
    }
    
    /**
     * Order active first
     *
     */
    public function scopeActiveFirst($query)
    {
        return $query->orderBy('name','asc')->orderBy('active','desc');
    }
    
   
}
