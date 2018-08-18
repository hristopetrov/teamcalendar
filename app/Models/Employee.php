<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'start', 'end', 'user_id','vacations_contract', 'vacations_extra'
    ];
        /**
	 * The primary key for the model.
	 *
	 * @var string
	 */    
    public $primaryKey = 'user_id';
    	
	/**
	 * Indicates if the IDs are auto-incrementing.
	 *
	 * @var bool
	 */
	public $incrementing = false;
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps =false;

    /**
    * Get the user user.
    */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    
}
