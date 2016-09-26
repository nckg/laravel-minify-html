<?php


namespace Nckg\Minify\Middleware;

use Closure;
use Nckg\Minify\Minifier;

class MinifyResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var Response $response */
        $response = $next($request);

        if (app()->isLocal()) {
            $response->setContent((new Minifier)->html($response->getContent()));
        }

        return $response;
    }
}