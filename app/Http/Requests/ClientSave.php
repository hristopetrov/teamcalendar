<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientSave extends FormRequest
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
            'active' => 'boolean',
        ];
        
        if ($this->isMethod('put')) {
        	$client_id = $this->route('id');
        	if (empty($client_id)) { 
        		return false;
        	}
        	$return['name'] = [
        		'required',
        		'string',
        		'max:30',
        		Rule::unique('clients')->ignore($client_id),
        	];
        } else {
			$return['name'] = 'required|string|max:30|unique:clients';
        }
        
        return $return;
        
    }
}
