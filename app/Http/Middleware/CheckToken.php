<?php

namespace App\Http\Middleware;

use App\Models\Token;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $header = request()->header('Authorization');
        $hashToken = explode(" ", $header)[1];
        $token = Token::where('token', $hashToken)->first();
        
        if(!$token){
            $response['message'] = "Token invalid!";
            return response()->json($response);
        }
        return $next($request);
    }
}
