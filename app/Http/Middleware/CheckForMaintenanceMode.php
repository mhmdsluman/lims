<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckForMaintenanceMode
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (config('settings.maintenance_mode', false) && !$this->app->runningInConsole()) {
            // Allow access to login and logout
            if ($request->is('login') || $request->is('logout')) {
                return $next($request);
            }

            // Allow admins to access the site
            if ($request->user() && $request->user()->role === 'admin') {
                return $next($request);
            }

            abort(503, config('settings.maintenance_message', 'The system is under maintenance. Please try again later.'));
        }

        return $next($request);
    }
}
