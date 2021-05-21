<?php
namespace Blocked\User;

/**
 * Class AddUserRole
 *
 * @package Blocked\User
 */
class AddUserRole {

    /**
     * AddUserRole constructor.
     */
    public function __construct() {
        add_action( 'init', [ $this, 'add_blocked_user_role' ] );
        add_filter( 'query_vars', [ $this, 'query_vars_render' ] );
        add_action( 'template_redirect', [ $this, 'template_redirect_render' ] );
    }

    /**
     * add blocker user role and  regiser rewrite url
     *
     * @return  void
     */
    public function add_blocked_user_role(){
        add_role(
            'blocked_user_role',
            'Blocked User',
             [
                 'Blocked' => true,
            ]
        );

        add_rewrite_rule( 'blocked/?$', 'index.php?blocked=1', 'top' );

    }

    /**
     * show blocked user content
     *
     * @param $query_vars
     *
     * @return mixed
     */
    public function query_vars_render( $query_vars ) {
        $query_vars[]  = 'blocked';

        return $query_vars;
    }

    public function template_redirect_render() {
        $is_blocked = intval( get_query_var( 'blocked' ) );

        if ( $is_blocked ) {
            echo "<h2> You are blocked user. </h2>";
            exit();
        }
    }
}