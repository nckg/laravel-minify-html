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

        if (config('app.debug') === false && $this->isHtml($response)) {
            $response->setContent((new Minifier())->html($response->getContent()));
        }

        return $response;
    }

     /**
     * Check if the content type header is html.
     *
     * @param \Illuminate\Http\Response $response
     *
     * @return bool
     */
    protected function isHtml($response)
    {
        $type = $response->headers->get('Content-Type');
        return strtolower(strtok($type, ';')) === 'text/html';
    }
}
