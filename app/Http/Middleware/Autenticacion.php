<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\TokenUsuario;

class Autenticacion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    { 
        if (!empty($request->bearerToken())) {
            $usuario = TokenUsuario::where('token', $request->bearerToken())->first();
            if (!empty($usuario)) {
                return $next($request);
            }
            else{
                return response()->json(['res' => true, 'message' => "No autorizado, token inválido"],200);
            }
            
        }else{
            return response()->json(['res' => true, 'message' => "No autorizado"],403);
        }
    }
}
