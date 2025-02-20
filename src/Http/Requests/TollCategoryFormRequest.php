<?php

namespace Codificar\Toll\Http\Requests;

use Codificar\Toll\Models\TollCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TollCategoryFormRequest extends FormRequest
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
            
            'name' => 'required',
            'exists' => 'required'
        ];
    }

    public function messages() {
		return [
			'exists' => trans('category.name.toll_category_exist')
		];
	}

    protected function prepareForValidation()
    {
        $exist = true;

        if($this->editMode == false){
            $tollCategory = TollCategory::validadeIfExist($this->name);

            if($tollCategory){
                $exist = null;
            }
        }

        // Envia os dados para a request
        $this->merge([
            'exists' => $exist
        ]);
	}


    /**
     * retorna um json caso a validação falhe.
     */
    public function failedValidation(Validator $validator) 
    {
        throw new HttpResponseException(
            response()->json(
                    [
                        'success' => false,
                        'errors' => $validator->errors()->all(),
                        'error_code' => \ApiErrors::REQUEST_FAILED
                    ]
            )
        );
    }
}
