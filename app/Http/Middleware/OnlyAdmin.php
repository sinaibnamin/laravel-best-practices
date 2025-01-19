<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Adminuser;
use Cookie;


class OnlyAdmin
{
   
    public function handle(Request $request, Closure $next)
    {
        $get_cookie = Cookie::get('admin_cookie');

        if (!$get_cookie) {
            abort(403, 'Unauthorized action.');
        }

        $cookie_role = json_decode($get_cookie)->role;

        if($cookie_role == 'admin'){
            return $next($request);
        }

        abort(403, 'Unauthorized action.');

    }
}
