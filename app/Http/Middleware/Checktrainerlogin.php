<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Trainer;
use Illuminate\Support\Facades\Cookie;
use App\Traits\FlashMessageTrait;

class Checktrainerlogin
{
    use FlashMessageTrait;

    public function handle(Request $request, Closure $next)
    {
       
        try {
            // Retrieve the trainer cookie
            $get_cookie = Cookie::get('trainer_cookie');

            // Check if the cookie exists
            if (!$get_cookie) {
                abort(403, 'Unauthorized action: No cookie found.');
            }

            // Decode the cookie
            $decoded_cookie = json_decode($get_cookie);

            // Check if cookie data is valid
            if (!$decoded_cookie || !isset($decoded_cookie->password) || !isset($decoded_cookie->username)) {
                abort(403, 'Unauthorized action: Invalid cookie data.');
            }

            $cookie_password = $decoded_cookie->password;
            $cookie_username = $decoded_cookie->username;

            // Fetch trainer information from the database
            $trainerdbinfo = Trainer::where('phone_number', $cookie_username)->first();

            // Check if trainer exists and validate credentials
            if (!$trainerdbinfo || $cookie_password != $trainerdbinfo->password) {
                Cookie::queue(Cookie::forget('trainer_cookie'));
                abort(403, 'Unauthorized action: Invalid credentials.');
            }


            if (!in_array($trainerdbinfo->status, ['Active', 'Pending'])) {
                Cookie::queue(Cookie::forget('trainer_cookie'));
                abort(403, 'Unauthorized action: Account not active');
            }


            return $next($request);



        } catch (\Exception $e) {
            Cookie::queue(Cookie::forget('trainer_cookie'));
            $this->flash_msg('danger', 'Please log in again.');
            return redirect('/trainer_panel/login');
        }
    }
}