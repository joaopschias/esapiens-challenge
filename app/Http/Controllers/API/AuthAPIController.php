<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\User\RegisterAPIRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class AuthAPIController extends BaseAPIController
{
    use SendsPasswordResetEmails;

    /**
     * POST api/login
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->input('username'), 'password' => $request->input('password')])) {
            return app()->handle(Request::create('/oauth/token', 'POST', $request->all()));
        }

        return $this->sendError(__('auth.failed'), [], 401);
    }

    /**
     * POST api/register
     *
     * @param RegisterAPIRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterAPIRequest $request)
    {
        $requestSanitized = $request->validated();
        $user = User::create($requestSanitized);
        $user->sendEmailVerificationNotification();

        $request->request->add(['username' => $user->email]);

        $data = $request->only([
            'username',
            'password',
            'grant_type',
            'client_id',
            'client_secret',
            'scope',
        ]);

        return app()->handle(Request::create('/oauth/token', 'POST', $data));
    }
}
