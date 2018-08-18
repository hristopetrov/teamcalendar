<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;



class UserSave extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $return = [
            'firstname' => 'required|string|max:30',
            'lastname' => 'required|string|max:30',
            'admin' => 'boolean',
        ];
        
        if ($this->isMethod('put')) {
        	$user_id = $this->route('id');
        	if (empty($user_id)) { 
        		$user_id = Auth::id();
        	}
        	$return['email'] = [
        		'required',
        		'email',
        		'max:40',
        		Rule::unique('users')->ignore($user_id),
        	];
            $return['start'] = [
                'required',
                'date'
            ];
            $return['end'] = [
                'date',
                'nullable'
            ];
            
        } else {
			$return['email'] = 'required|email|max:40|unique:users';
//             $return['password'] = 'min:8|confirmed';
        }
        
        return $return;
        
    }
}
