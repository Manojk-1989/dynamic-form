<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FormBuilderRequest extends FormRequest
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
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],

            'label' => ['required', 'array'],
            'label.*' => ['required', 'string', 'max:255'],

            'name' => ['required', 'array'],
            'name.*' => ['required', 'string', 'max:255'],

            'field_type' => ['required', 'array'],
            'field_type.*' => ['required', Rule::in(['text', 'number', 'textarea', 'select', 'radio', 'checkbox'])],

            'required' => ['nullable', 'array'],
            'required.*' => ['nullable', Rule::in(['1'])],

            'options_or_values' => ['nullable', 'array'],
            'options_or_values.*' => ['nullable', 'string'],

        ];
    }


    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $fieldTypes = $this->input('field_type', []);
            $options = $this->input('options_or_values', []);

            // Check that select/radio/checkbox fields have options
            foreach ($fieldTypes as $index => $type) {
                if (in_array($type, ['select', 'radio', 'checkbox'])) {
                    if (empty($options[$index])) {
                        $validator->errors()->add("options_or_values.$index", "Options are required for {$type} field at index {$index}.");
                    } else {
                        // Validate JSON format of options
                        json_decode($options[$index], true);
                        if (json_last_error() !== JSON_ERROR_NONE) {
                            $validator->errors()->add("options_or_values.$index", "Invalid JSON for options at index {$index}.");
                        }
                    }
                }
            }
        });
    }
}
