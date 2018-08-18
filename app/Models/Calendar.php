<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    /*
     * The table name
     *
     * @var string
     */
    protected $table = 'calendar';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date', 'user_id', 'project_id', 'client_id', 'length', 'away', 'comment'
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
	    'allday' => 'boolean',
	];
    

    /**
     * Get the project for this calendar.
     */
    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }
    
    /**
     * Get the project for this calendar.
     */
    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }
    
    /**
     * Get the project for this calendar.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }    
    
    /**
     * Shows active only
     *
     */
    public function scopeDateRange($query,$start,$end)
    {
        return $query->where('date','>=',$start)->where('date','<',$end);
    }  

    public function scopeNotInWorkDays($query,$reason)
    {
        return $query->whereYear('date',date('Y'))->where('away',$reason)->count('away');
    }      
}
