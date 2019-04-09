<?php

namespace App\Api\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Middleware для проверки json-заголовков.
 */
class Json
{
    /**
     * @param Request $request
     * @param Closure $next
     *
     * @return JsonResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        $type = 'application/json';
        $acceptHeader = $request->header('Accept');

        if (strpos($acceptHeader, $type) === false) {
            return $this->badRequestResponse();
        }


        if (\in_array($request->method(), ['POST', 'PUT', 'PATCH'])) {
            $contentTypeHeader = $request->header('Content-Type');
            if (strpos($contentTypeHeader, $type) === 0) {
                return $this->badRequestResponse();
            }
        }

        return $next($request);
    }

    /**
     * @return JsonResponse
     */
    protected function badRequestResponse(): JsonResponse
    {
        return response()->json([
            'error' => [
                'message' => __('Bad request'),
            ]
        ], 400);
    }
}
