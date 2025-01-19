<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Cookie;
use App\Traits\FlashMessageTrait;

class Checkmemberlogin
{
    use FlashMessageTrait;

    public function handle(Request $request, Closure $next)
    {
        try {
            $get_cookie = Cookie::get('member_cookie');

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

            // Fetch member information from the database
            $memberdbinfo = Member::where('phone_number', $cookie_username)->first();

            // Check if member exists and validate credentials
            if (!$memberdbinfo || $cookie_password !== $memberdbinfo->password) {
                Cookie::queue(Cookie::forget('member_cookie'));
                abort(403, 'Unauthorized action: Invalid credentials.');
            }

            // Check if member status is active or pending or approve
            if (in_array($memberdbinfo->status, ['Inactive', 'Archive'])) {
                Cookie::queue(Cookie::forget('member_cookie'));
                abort(403, 'Your account is not active, please contact admin.');
            }

            return $next($request);
        } catch (\Exception $e) {
            // Handle any exceptions that occur
            Cookie::queue(Cookie::forget('member_cookie'));
            $this->flash_msg('danger', 'Please log in again.');
            return redirect('/member_panel/login');
        }
    }
}
