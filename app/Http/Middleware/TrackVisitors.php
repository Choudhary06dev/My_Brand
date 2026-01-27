<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Visitor;

class TrackVisitors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $ip = $request->ip();
            $today = now()->startOfDay();

            // Check if this IP has visited today
            // We can check if a visitor record exists for this IP created today
            $visitor = Visitor::where('ip_address', $ip)
                ->whereDate('created_at', $today)
                ->first();

            if (!$visitor) {
                Visitor::create([
                    'ip_address' => $ip,
                    'user_agent' => $request->header('User-Agent'),
                    'page_url' => $request->fullUrl(),
                ]);
            }
        } catch (\Exception $e) {
            // Silently fail if there is a database issue with the visitors table
            // This prevents the whole site from crashing
            \Log::error('Visitor tracking failed: ' . $e->getMessage());
        }

        return $next($request);
    }
}
