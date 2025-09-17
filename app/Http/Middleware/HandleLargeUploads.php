<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleLargeUploads
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Increase PHP limits for ALL requests that might involve file uploads
        // This ensures limits are set early in the request lifecycle

        // Set ultra-high limits for property routes BEFORE any processing
        if ($request->route() && str_contains($request->route()->getName() ?? '', 'properties')) {
            // Set extremely high limits to handle large uploads
            ini_set('upload_max_filesize', '500M');
            ini_set('post_max_size', '600M');
            ini_set('max_execution_time', '1800'); // 30 minutes
            ini_set('max_input_time', '1800');
            ini_set('memory_limit', '2048M');
            ini_set('max_file_uploads', '100');

            // Try to set via Apache environment if available
            if (function_exists('apache_setenv')) {
                apache_setenv('upload_max_filesize', '500M');
                apache_setenv('post_max_size', '600M');
            }
        }

        return $next($request);
    }
}
