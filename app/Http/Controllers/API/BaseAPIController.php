<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

/**
 * Class BaseAPIController
 */
class BaseAPIController extends Controller
{
    /**
     * @param string $message
     * @param mixed  $data
     *
     * @return array
     */
    public static function createResponse($message, $data = [])
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        if (!empty($data)) {
            if(array_key_exists('data', $data)){
                $response = array_merge($response, $data);
            } else {
                $response['data'] = $data;
            }
        }

        return $response;
    }

    /**
     * @param string $message
     * @param array  $data
     *
     * @return array
     */
    public static function createError($message, $data = [])
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if (!empty($data)) {
            $response['data'] = $data;
        }

        return $response;
    }

    public function sendResponse($result, $message = 'Ação efetuada com sucesso')
    {
        return response()->json($this->createResponse($message, $result));
    }

    public function sendError($message, $data = [], $code = 404)
    {
        return response()->json($this->createError($message, $data), $code);
    }

    public function validationError($message = 'Erro de validação', $data = [])
    {
        return response()->json($this->createError($message, $data), 400);
    }

    public function unauthorizedError()
    {
        return response()->json($this->createError('Não autorizado'), 401);
    }
}
