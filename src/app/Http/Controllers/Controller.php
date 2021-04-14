<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function jsonResponse(array $data = [], int $httpCode = 200)
    {
        return response()->json($data, $httpCode);
    }

    protected function errorResponse($errorCode = null, $message = null, $httpCode = 500)
    {
        $data['message'] = $message ?: 'Something went wrong...';
        
        if($errorCode) {
            $data['error_code'] = $errorCode;
        }

        return response()->json($data, $httpCode);
    }
}
