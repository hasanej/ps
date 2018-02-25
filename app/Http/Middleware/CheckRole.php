<?php

/** 
*
* @author       : Hasan El Jabir <eljabirhasan@gmail.com>
* @copyright    : Gunadarma University Computing Center
* @contact      : 0812 8923 3370 
*
**/

namespace App\Http\Middleware;

use Closure;

class CheckRole
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
        //Cek apakah user adalah admin
        if(auth()->check() && $request->user()->id_role < 3)
        {
            //Proses ke tampilan halaman admin
            return $next($request);
        }

        //Proses jika user bukanlah admin
        return redirect()->guest('/');
    }

}
