<?php

namespace App\Api\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;

/**
 * Middleware для проверки json-заголовков.
 */
class Json
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        $type = 'application/json';
        $acceptHeader = $request->header('Accept');

        if ($acceptHeader !== $type) {
            return $this->badRequestResponse();
        }


        if (\in_array($request->method(), ['POST', 'PUT', 'PATCH'])) {
            $contentTypeHeader = $request->header('Content-Type');
            if (strpos($contentTypeHeader, $type) !== 0) {
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
