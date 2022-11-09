<?php
namespace App\Http\Request\Securite;


use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST': {
                return [
                    'nom' => 'string | required',
                    'prenom' => 'string | required',
                    'email' => 'string | required | max:255',
                    'login_windows' => 'string | required',
                    'structure_id' => 'numeric',
                    'role_base' => 'numeric'
                ];
            }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'nom' => 'string | required',
                        'prenom' => 'string | required',
                        'email' => 'string | required | max:255',
                        'login_windows' => 'string | required',
                        'structure_id' => 'numeric',
                        'is_active' => 'boolean',
                        'role_base' => 'numeric'
                    ];
                }
            default:
                break;
        }

    }
}
