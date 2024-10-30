<?php

/**
 * CookieLaw.eu // Extensions CLASS
 *
 * @package   CookieLaw.eu\WP
 * @copyright Copyright (C) 2018, Swypelab SRL - info@swypelab.com
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3 or higher
 */
if (!defined('ABSPATH')) {
    die("Oh, c'mon!");
}

class CookieLaw_WP_Extensions {

    static $instance = null;

    public function __construct() {
        // WPBakery Page Builder (formerly Visual Composer) extension
        add_action('vc_before_init', array($this, 'vc_map'));
    }

    public function vc_map() {
        if (!function_exists('vc_map')) {
            return;
        }

        vc_map(array(
            "name" => __("Embedded cookie policy", "cookielaw-eu"),
            "base" => "cl_embedded_policy",
            "icon" => CL_PLUGIN_ASSETS_URL . "images/icon-128x128.png",
            "description" => __("Embed your generated cookie policy by Cookielaw.eu", "cookielaw-eu"),
            "category" => __("Cookielaw.eu", "lt"),
            "show_settings_on_create" => false
        ));
    }

    static function get_instance() {
        if (static::$instance == null) {
            $instance = new self();
        }
        return $instance;
    }

}

CookieLaw_WP_Extensions::get_instance();
