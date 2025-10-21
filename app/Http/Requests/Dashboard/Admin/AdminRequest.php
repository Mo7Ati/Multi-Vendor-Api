<?php

namespace App\Http\Requests\Dashboard\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('admins', 'email')->ignore($this->admin?->id)],
            'is_active' => ['boolean'],
            'roles' => ['nullable', 'array'],
        ];

        // Make password required only for create, nullable for update
        if ($this->isMethod('POST')) {
            $rules['password'] = ['required', 'string', 'min:8'];
        } else {
            $rules['password'] = ['nullable', 'string', 'min:8'];
        }

        return $rules;
    }


    public function messages(): array
    {
        $messages = [
            'name.required' => __('messages.required'),
            'name.string' => __('messages.string'),
            'name.max' => __('messages.max'),
            'email.required' => __('messages.required'),
            'email.email' => __('messages.email'),
            'email.unique' => __('messages.unique'),
            'password.string' => __('messages.string'),
            'password.min' => __('messages.min'),
            'roles.array' => __('messages.array'),
            'is_active.boolean' => __('messages.boolean'),
        ];

        // Add password required message only for create requests
        if ($this->isMethod('POST')) {
            $messages['password.required'] = __('messages.required');
        }

        return $messages;
    }

    public function attributes(): array
    {
        return [
            'name' => __('attributes.name'),
            'email' => __('attributes.email'),
            'password' => __('attributes.password'),
            'is_active' => __('attributes.is_active'),
            'roles' => __('attributes.roles'),
        ];
    }
}
