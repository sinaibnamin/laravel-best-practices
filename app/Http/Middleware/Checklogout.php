<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Adminuser;
use Cookie;

class Checklogout
{

    public function handle(Request $request, Closure $next)
    {
        $get_cookie_admin = Cookie::get('admin_cookie');
        $get_cookie_member = Cookie::get('member_cookie');
        $get_cookie_trainer = Cookie::get('trainer_cookie');

        if ($get_cookie_admin) {
            return redirect('/admin_panel');
        }
        if ($get_cookie_member) {
            return redirect('/member_panel');
        }
        if ($get_cookie_trainer) {
            return redirect('/trainer_panel');
        }
        return $next($request);
    }

}
