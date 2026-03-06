<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentSecurityPolicy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Prepare the basic CSP rules
        $csp = "default-src 'self'; " .
               "script-src 'self' 'unsafe-inline' 'unsafe-eval'; " .
               "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://fonts.gstatic.com; " .
               "font-src 'self' https://fonts.gstatic.com; " .
               "img-src 'self' data: https: http:; " .
               "connect-src 'self'; " .
               "frame-src 'self' https://www.youtube.com https://youtube.com;";

        // Append header only if response is an instance of Symfony Response (this includes Illuminate Response)
        if (method_exists($response, 'header') || property_exists($response, 'headers')) {
            $response->headers->set('Content-Security-Policy', $csp);
        }

        return $response;
    }
}
