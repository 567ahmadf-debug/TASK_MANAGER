<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckNameUser
{

    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user()->name === 'ahmad') 
        return $next($request);

        return response()->json(["message"=>"isn't ahmad !!"] , 403) ; 
    }
}
