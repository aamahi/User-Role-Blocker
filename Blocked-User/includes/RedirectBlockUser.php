<?php


namespace Blocked\User;

/**
 * Class RedirectBlockUser
 *
 * @package Blocked\User
 */
class RedirectBlockUser {
    /**
     * RedirectBlockUser constructor.
     */
    public function __construct() {
        add_action( 'init', [ $this, 'redirect_blocked_user_render' ] );
    }

    /**
     * redirect blocked page
     *
     * @return void
     */
    public function redirect_blocked_user_render() {
        if ( is_admin() && current_user_can( 'blocked' ) ) {
            wp_redirect( get_home_url() . '/blocked' );
            die();
        }
    }
}
