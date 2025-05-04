<?php

namespace App\Http\Requests\MaterialManagement;

use Illuminate\Foundation\Http\FormRequest;

class StickerTypeMaterialRequest extends FormRequest
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
            'sticker_type_id' => 'required|exists:sticker_types,id',
            'material_id' => 'required|exists:materials,id',
            'sort_order' => 'nullable|numeric',
        ];
    }
}
