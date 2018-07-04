<?php

namespace App\Http\Requests;

use App\Models\Inbound\Folder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateFolderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                Rule::notIn(Folder::PROTECTED_FOLDER_NAMES),
                Rule::unique('folders')->where(function ($query) {
                    return $query->where('user_id', auth()->user()->id);
                }),
            ],
        ];
    }

    public function prepareForValidation()
    {
        $input = $this->all();

        $input['name'] = ucwords($input['name']);

        $this->merge($input);
    }
}
