<?php

namespace App\Http\Requests\API\Comment;

use App\Models\Comment;
use Illuminate\Foundation\Http\FormRequest;

class CreateCommentRequest extends FormRequest
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
        return Comment::$standard_rules;
    }

    /**
     * Get the validation labels that apply to the request.
     *
     * @return array
     */
    public function attributes(): array
    {
        return Comment::$rules_labels;
    }

    /**
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function getValidatorInstance()
    {
        $validator = FormRequest::getValidatorInstance();
        $user = $this->user();
        $owner = $this->post->user;
        $lastComment = $user->comments()->latest()->first();

        $validator->after(function () use ($validator, $user, $owner, $lastComment) {
            if(!$user->isA('subscriber') and !$owner->isA('subscriber') and $this->get('value') <= 0){
                $validator->errors()->add('value', 'Você não pode comentar em postagens de usuários não assinantes. Por favor insira moedas realizar o comentário');
            }

            if(!empty($this->get('value')) and $this->get('value') > 0 and ($user->balance - $this->get('value') < 0)){
                $validator->errors()->add('value', 'Você não possui saldo sufiiciente. Por favor reduza o valor de moedas');
            }

            if(!empty($lastComment) and $lastComment->created_at->diffInSeconds(now()) < 60){
                $validator->errors()->add('value', 'Você já realiazou um comentário nos últimos 60 segundos. Aguarde para comentar novamente');
            }
        });

        return $validator;
    }
}
