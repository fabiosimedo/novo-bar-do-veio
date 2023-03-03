<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // TODO: Add your logic here.


        $admin = User::where('isadmin', 1)->pluck('name');

        // if(auth()->user()->name !== $admin[0]) {
        //     return redirect()->back()
        //            ->with('logado', 'Sem permissão de acesso para esta página...');
        // }

        if(!auth()->user() || $admin[0] !== auth()->user()->name) {
            return redirect()->back()
            ->with('logado', 'Você não permissão para acessar essa página...');
        }

        return $next($request);
    }
}
