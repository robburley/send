<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendEmailRequest extends FormRequest
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
            'to.*'    => 'required|email',
            'cc.*'    => 'email',
            'subject' => 'required|max:255',
            'content' => 'required',
            'files.*' => 'file|required',
        ];
    }

    public function messages()
    {
        return [
            'to.*.required' => 'You must specify an email address to send to',
            'to.*.email'    => 'Each email address you send to must be valid',
            'cc.*.email'    => 'Each email address you Cc to must be valid',
        ];
    }

    public function prepareForValidation()
    {
        $input = $this->all();

        $input['to'] = array_map('trim', explode(',', $input['to']));

        $input['cc'] = array_map('trim', explode(',', $input['cc']));

        $this->merge($input);
    }
}
