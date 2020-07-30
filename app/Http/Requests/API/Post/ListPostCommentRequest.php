<?php

namespace App\Http\Requests\API\Post;

use Illuminate\Foundation\Http\FormRequest;

class ListPostCommentRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'page' => 'nullable|numeric',
        ];
    }

    /**
     * Get the validation labels that apply to the request.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'page' => 'Número da Página',
        ];
    }
}
