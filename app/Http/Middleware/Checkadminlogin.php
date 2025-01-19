<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Adminuser;
use Illuminate\Support\Facades\Cookie;
use App\Traits\FlashMessageTrait;

class Checkadminlogin
{
    use FlashMessageTrait;

    public function handle(Request $request, Closure $next)
    {
        try {
         
            // Retrieve the admin cookie
            $get_cookie = Cookie::get('admin_cookie');

            // Check if the cookie exists
            if (!$get_cookie) {
                abort(403, 'Unauthorized action: No cookie found.');
            }

            // Decode the cookie
            $decoded_cookie = json_decode($get_cookie);

            // Validate cookie data
            if (!$decoded_cookie || !isset($decoded_cookie->password) || !isset($decoded_cookie->username)) {
                abort(403, 'Unauthorized action: Invalid cookie data.');
            }

            $cookie_password = $decoded_cookie->password;
            $cookie_username = $decoded_cookie->username;

            // Fetch admin user information from the database
            $admindbinfo = Adminuser::where('username', $cookie_username)->first();

            // Check if admin user exists and validate credentials
            if ($admindbinfo && $cookie_password === $admindbinfo->password) {
                return $next($request);
            } else {
                Cookie::queue(Cookie::forget('admin_cookie'));
                abort(403, 'Unauthorized action: Invalid credentials.');
            }
        } catch (\Exception $e) {
            // Handle any exceptions that occur
            Cookie::queue(Cookie::forget('admin_cookie'));
            $this->flash_msg('danger', 'Please log in again.');
            return redirect('/admin_panel/login');
        }
    }
}
