<?php

namespace App\Http\Middleware;

use App\Models\PersonalAccessToken; // Import the missing class
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken(); // Lấy token từ header Authorization

        if ($token) {
            try {
                $tokenModel = PersonalAccessToken::findToken($token);
                if ($tokenModel && $request->uid == $tokenModel->tokenable_id) {
                    return $next($request);
                }
            } catch (\Exception $e) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        }
        return response()->json(['error' => 'Unauthorized'], 403);
    }
}
