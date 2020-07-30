<?php

namespace App\Http\Requests\API\Post;

use App\Models\Comment;
use Illuminate\Foundation\Http\FormRequest;

class DeletePostCommentRequest extends FormRequest
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
        return [];
    }

    /**
     * Get the validation labels that apply to the request.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [];
    }

    /**
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function getValidatorInstance()
    {
        $validator = FormRequest::getValidatorInstance();
        $user = $this->user;
        $owner = $this->post->user;

        $validator->after(function () use ($validator, $user, $owner) {
            if($user->id != $owner->id){
                $validator->errors()->add('value', 'Você não pode realizar essa ação');
            }
        });

        return $validator;
    }
}
