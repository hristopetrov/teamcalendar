<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id', 'name', 'active', 'color', 'budgeted', 'deadline',
    ];
    
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
	public $timestamps = false;
	
	/**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 20;
    
    /**
     * Casting
     *
     * @var array
     */
    protected $casts = [
	    'active' => 'boolean',
	];
    

    /**
     * Get the client for this project.
     */
    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }
    
	/**
    * Get the calendars for this project.
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
