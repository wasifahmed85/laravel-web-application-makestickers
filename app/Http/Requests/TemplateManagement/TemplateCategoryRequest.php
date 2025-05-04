<?php

namespace App\Http\Requests\TemplateManagement;

use Illuminate\Foundation\Http\FormRequest;

class TemplateCategoryRequest extends FormRequest
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
            'name' => 'required|min:3|max:255',
        ]+
        ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    public function store(): array
    {
        return [
            'slug' => 'required|min:3|max:255|unique:template_categories',
        ];
    }

    public function update(): array
    {
        return [
            'slug' => 'required|min:3|max:255|unique:template_categories,slug,'.decrypt($this->route('template_category')),
        ];
    }   
}
