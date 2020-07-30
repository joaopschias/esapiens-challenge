<?php


namespace App\Http\Requests\API\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordAPIRequest extends FormRequest
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
        return User::$update_password_rules;
    }

    /**
     * Get the validation labels that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return User::$rules_labels;
    }
}
