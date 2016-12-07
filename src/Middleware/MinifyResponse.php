<?php

namespace Nckg\Minify\Middleware;

use Closure;
use Nckg\Minify\Minifier;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MinifyResponse
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var Response $response */
        $response = $next($request);

        if (!app()->isLocal() and false === is_a($response, StreamedResponse::class)) {
            $response->setContent((new Minifier())->html($response->getContent()));
        }

        return $response;
    }
}
