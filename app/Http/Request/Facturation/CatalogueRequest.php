<?php
namespace App\Http\Request\Facturation;


use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CatalogueRequest extends FormRequest
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
                    'nom_partenaire' => 'string | required | max:255',
                    'num_ap' => 'numeric | required',
                    'type_partenaire_id' => 'numeric | required',
                    'inclure_id' => 'numeric | required',
                    'taux_commission' => 'numeric',
                    'mode_reversement_id' => 'numeric',
                    'compte_bancaire' => 'numeric',
                    'car' => 'array'
                ];
            }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'nom_partenaire' => 'string | required | max:255',
                        'num_ap' => 'numeric | required',
                        'type_partenaire_id' => 'numeric | required',
                        'inclure_id' => 'numeric | required',
                        'taux_commission' => 'numeric',
                        'mode_reversement_id' => 'numeric',
                        'compte_bancaire' => 'numeric',
                        'car' => 'array'
                    ];
                }
            default:
                break;
        }

    }
}
