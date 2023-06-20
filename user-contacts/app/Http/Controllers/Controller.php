<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function sendDataWithMessage(
        string $message,
        array|Collection|JsonResource|bool $data,
        ?int $statusCode = Response::HTTP_OK
    ): JsonResponse
    {
        return response()->json(
            [
                'message' => $message,
                'content' => $data
            ],
            $statusCode
        );
    }

    protected function sendMessage(
        string $message,
        ?int $statusCode = Response::HTTP_OK
    ): JsonResponse
    {
        return response()->json(
            [
                'message' => $message,
            ],
            $statusCode
        );
    }

    public function sendCustomValidationError(array|Collection|JsonResource|bool $data): JsonResponse
    {
        return response()->json(
            [
                'message' => 'The given data was invalid.',
                'errors' => $data
            ],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    protected function sendError(
        string $errorMessage,
        int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR
    ): JsonResponse
    {
        return response()->json(['error' => $errorMessage], $statusCode);
    }

    protected function sendPaginatedData(
        string $message,
        int $total,
        ?string $nextPage,
        JsonResource $data
    )
    {
        return response()->json(
            [
                'message' => $message,
                'total' => $total,
                'nextPageUrl' => $nextPage,
                'content' => $data
            ]
        );
    }
}
