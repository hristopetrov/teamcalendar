<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalendarSaveAway extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'away' => 'nullable|in:vacation,sick,other',
			'comment' => 'string|nullable',
        ];
	        
	    if ($this->isMethod('put')) {
		    
		    $return = [
				'comment' => 'string|nullable',
	        ];

		}
        
        return $return;
    }
}
