<?php

namespace App\Traits\Http;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ApiResponses
{
    protected function sendSuccessResponse(
        ?string $message = null,
        mixed $data = null,
        mixed $code = null,
        array $headers = []
    ): JsonResponse {
        if (!array_key_exists($code, Response::$statusTexts)) {
            $code = Response::HTTP_OK;
        }

        $finalResponseData = [];

        if (!empty($message)) {
            $finalResponseData['message'] = $message;
        }

        if (!empty($data)) {
            $finalResponseData['data'] = $data;
        }

        return response()->json($finalResponseData, $code, $headers);
    }

    protected function sendErrorResponse(
        string $message,
        array $data = [],
        mixed $code = null,
        array $headers = []
    ): JsonResponse {
        if (!array_key_exists($code, Response::$statusTexts)) {
            $code = Response::HTTP_BAD_REQUEST;
        }

        $finalResponseData = ['message' => $message];

        if (!empty($data)) {
            $finalResponseData['data'] = $data;
        }

        return response()->json($finalResponseData, $code, $headers);
    }
}
