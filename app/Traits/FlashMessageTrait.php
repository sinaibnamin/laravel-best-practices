<?php

namespace App\Traits;

use Illuminate\Support\Facades\Session;

trait FlashMessageTrait {

    protected $app_environment;

    public function __construct() {
        $this->app_environment = env( 'APP_ENV', 'production' );
    }

    protected function flash_msg( $type, $message ) {
        Session::flash( 'message', $message );
        Session::flash( 'alert-class', 'success' );
        Session::flash( 'icon-class', 'fas fa-check' );

        if ( $type == 'warning' ) {
            Session::flash( 'alert-class', 'warning' );
            Session::flash( 'icon-class', 'fa-solid fa-triangle-exclamation' );
        }

        if ( $type == 'danger' ) {
            Session::flash( 'alert-class', 'danger' );
            Session::flash( 'icon-class', 'fa-sharp fa-solid fa-rectangle-xmark' );

        }
    }

    protected function flash_and_back( $type, $message ) {
        $this->flash_msg( $type, $message );
        return redirect()->back();

    }

}
