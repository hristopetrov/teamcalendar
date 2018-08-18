<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectSave extends FormRequest
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
            'client_id' => 'required|exists:clients,id',
            'name' => 'required|string|max:30',
            'budget' => 'numeric',
            'deadline' => 'date',
            'color' => 'string|nullable|min:6|max:6',
        ];
        
        return $return;
    }
}
