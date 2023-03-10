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


        $admin = User::where('name', auth()->user()->name)->pluck('name');


        if($admin[0] == 'Fabio Simedo' || $admin[0] == 'Kezzia Avigo') {

            return $next($request);
        }

        return redirect()->back()
            ->with('logado', 'Você não permissão para acessar essa página...');
    }
}
