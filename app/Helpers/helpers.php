<?php

use Illuminate\Support\Str;
use App\Models\Adminuser;

function createUniqueSlug($fullName)
{
    // Generate initial slug
    $slug = Str::slug($fullName, '_');
    $originalSlug = $slug;

    // Check if the slug already exists
    $count = 1;
    while (Adminuser::where('slug', $slug)->exists()) {
        $slug = "{$originalSlug}_{$count}";
        $count++;
    }

    return $slug;
}



function get_user_role() {
    $get_cookie = \Cookie::get('admin_cookie');
    if($get_cookie){
        $user_role = json_decode($get_cookie)->role;
        return $user_role;
    }
    $get_cookie = \Cookie::get('member_cookie');
    if($get_cookie){
        $user_role = json_decode($get_cookie)->role;
        return $user_role;
    }
    $get_cookie = \Cookie::get('trainer_cookie');
    if($get_cookie){
        $user_role = json_decode($get_cookie)->role;
        return $user_role;
    }




    return 'null';
};

function get_user_name() {
    $get_cookie = \Cookie::get('admin_cookie');
    if($get_cookie){
        $user_name = json_decode($get_cookie)->name;
        return $user_name;
    }
    $get_cookie = \Cookie::get('member_cookie');
    if($get_cookie){
        $user_name = json_decode($get_cookie)->name;
        return $user_name;
    }
    $get_cookie = \Cookie::get('trainer_cookie');
    if($get_cookie){
        $user_name = json_decode($get_cookie)->name;
        return $user_name;
    }

    return 'null';
};

function get_user_id() {
    $get_cookie = \Cookie::get('admin_cookie');
    if($get_cookie){
        $user_id = json_decode($get_cookie)->username;
        return $user_id;
    }
    $get_cookie = \Cookie::get('member_cookie');
    if($get_cookie){
        $user_id = json_decode($get_cookie)->username;
        return $user_id;
    }
    $get_cookie = \Cookie::get('trainer_cookie');
    if($get_cookie){
        $user_id = json_decode($get_cookie)->username;
        return $user_id;
    }

    return 'null';
};


