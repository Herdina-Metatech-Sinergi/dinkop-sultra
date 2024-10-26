<?php

namespace App\Http\Middleware;

use App\Models\IdentitasKoperasi;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckStatusKoperasi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // return $next($request);
        try {
            //code...
            if (auth()->user()->hasRole(['Admin Dinkop'])) {
                # code...
                return $next($request);
            }else{
                $identitas = IdentitasKoperasi::where('user_id',auth()->user()->id)->first();
                if ($identitas) {
                    # code...
                    if ($identitas->status == 'Setujui') {
                        # code...
                        return $next($request);

                    }
                }
            }

            if ($request->is('admin')) {
                return $next($request);
            }

            if (str_contains($request->getPathInfo(),'/admin/identitas-koperasis')) {
                # code...
                return $next($request);
            }

            if (str_contains($request->getPathInfo(),'/admin/logout')) {
                # code...
                return $next($request);
            }

            if (str_contains($request->getPathInfo(),'/admin/my-profile')) {
                # code...
                return $next($request);
            }

            if (str_contains($request->getPathInfo(),'/admin/themes')) {
                # code...
                return $next($request);
            }

            return redirect('admin');
        } catch (\Throwable $th) {
            //throw $th;
            return $next($request);

        }

    }
}
