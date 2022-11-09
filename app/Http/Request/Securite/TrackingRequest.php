<?php
namespace App\Http\Request\Securite;


use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TrackingRequest extends FormRequest
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
            'user' => 'string | required',
            'action' => 'string | required',
            'ip_machine' => 'string | required'
        ];
    }
}
