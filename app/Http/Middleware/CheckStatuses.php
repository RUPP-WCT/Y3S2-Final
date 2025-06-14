<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckStatuses
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$statuses): Response
    {
        $user = $request->user();

        $credentials = $request->validate([
            'email' => 'email',
            'password' => 'string|min:6',
        ]);

        if (!$user && isset($credentials['email']) && isset($credentials['password']) && !empty($credentials['email']) && !empty($credentials['password'])&& auth()->attempt($credentials)) {
            $user = auth()->user();
        }

        if ($user and !in_array($user->account_status_id, $statuses)) {
            return response()->json([
                'message' => 'Account issues',
                'data' => [
                    'status' => $user->accountStatus,
                    'status note' => $user->accountStatusNotes,
                ]
            ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
