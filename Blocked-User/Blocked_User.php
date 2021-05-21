<?php
namespace Blocked\User;

/**
 * Plugin Name:       Blocked User Plugin
 * Description:       Blocked a user, and she/he can't access the admin panel.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Abdullah Mahi
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       blocked-user
 * Domain Path:       /languages
 */


if ( ! defined( "ABSPATH" ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Class Blocked_User
 */
final class Blocked_User {
    /**
     * plugin current version
     *
     * @var string
     */
    const version = 1.01;

    /**
     * Blocked_User constructor.
     */
    public function __construct() {
        $this->defined_constant();

        register_activation_hook( __FILE__, [ $this, 'activate' ] );
        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );

    }

    /**
     *  Initialize a singleton instance
     *
     * @return Blocked_User|false
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new  self();
        }

        return $instance;
    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate() {
        $installed = get_option( 'blocked_user_installed' );

        if ( ! $installed ) {
            update_option( 'blocked_user_installed', time() );
        }

        update_option( 'blocked_user_version', BLOCKED_USER_VERSION );
    }

    /**
     * Define the required plugin constant
     *
     * @return void
     */
    public function defined_constant() {
        define( 'BLOCKED_USER_VERSION', self::version );
        define( 'BLOCKED_USER_FILE', __FILE__ );
        define( 'BLOCKED_USER_PATH', __DIR__ );
        define( 'BLOCKED_USER_URL', plugins_url('', BLOCKED_USER_FILE ) );
        define( 'BLOCKED_USER_ASSETS', BLOCKED_USER_URL . '/assets' );
    }

    /**
     * initialize the  plugin
     *
     * @return void
     */
    public function init_plugin() {
        new AddUserRole();
        new RedirectBlockUser();
    }

}

/**
 * initialize the main plugin function.
 *
 * @return Blocked_User|false
 */
function blocked_user_plugin() {
    return Blocked_User::init();
}

/**
 * kickoff the main plugin.
 */
blocked_user_plugin();