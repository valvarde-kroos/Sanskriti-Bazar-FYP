<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        $userRole = $user->role;

        // Check if user account is active
        if (!$user->is_active) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Your account has been deactivated. Please contact administrator.');
        }

        // Check if vendor is approved
        if ($userRole === 'vendor' && $user->approval_status !== 'approved') {
            auth()->logout();
            $message = $user->approval_status === 'pending' 
                ? 'Your vendor account is pending approval. Please wait for admin approval.'
                : 'Your vendor account has been declined. Please contact administrator.';
            return redirect()->route('login')->with('error', $message);
        }

        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}
