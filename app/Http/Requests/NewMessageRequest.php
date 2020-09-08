<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewMessageRequest extends FormRequest
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
        return [
            'message' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'message.required' => t('This field is required.'),
            'message.string' => t('This field must be string.')
        ];
    }

    /**
     * @return array|string|null
     */
    public function validationData()
    {
        return $this->post();
    }
}
