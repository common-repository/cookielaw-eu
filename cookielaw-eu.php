<?php

/**
 * CookieLaw.eu
 *
 * @package   CookieLaw.eu\WP
 * @copyright Copyright (C) 2018, Swypelab SRL - info@swypelab.com
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3 or higher
 *
 * @wordpress-plugin
 * Plugin Name: CookieLaw.eu
 * Version:     0.1.3
 * Plugin URI:  https://www.cookielaw.eu
 * Description: The Cookielaw.eu WordPress plugin helps you to install on your site the CookieLaw.eu script, a service that helps you manage and classify your site’s cookies in compliance with GDPR regulation.
 * Author:      Swypelab SRL
 * Author URI:  https://www.swypelab.com
 * License:     GPL v3
 * Text Domain: cookielaw-eu
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
if (!defined('ABSPATH')) {
    die("Oh, c'mon!");
}

class CookieLaw_WP {

    static $instance = null;
    private $templates_path = null;
    private $includes_path = null;

    public function __construct() {
        $path = plugin_basename(__FILE__);
        add_action('plugins_loaded', array($this, 'load_textdomain'));

        if (is_admin()) {
            add_action('admin_menu', array($this, 'admin_menu'));
            add_action('admin_init', array($this, 'register_settings'));
            add_action("plugin_action_links_{$path}", array($this, 'add_plugin_action'), 10, 3);
        }
        add_action('wp_enqueue_scripts', array($this, 'script_init'));

        $this->templates_path = dirname(__FILE__) . "/templates/";
        $this->includes_path = dirname(__FILE__) . "/includes/";

        define("CL_PLUGIN_URL", plugin_dir_url(__FILE__));
        define("CL_PLUGIN_ASSETS_URL", CL_PLUGIN_URL . "assets/");

        if (file_exists($this->includes_path . "/extensions.php")) {
            require_once $this->includes_path . "/extensions.php";
        }

        if (file_exists($this->includes_path . "/shortcodes.php")) {
            require_once $this->includes_path . "/shortcodes.php";
        }
    }

    public function add_plugin_action($actions) {
        return array_merge(array(
            'settings' => "<a href='" . esc_url(admin_url("options-general.php?page=cookielaw-settings")) . "'>" . __("Settings", "cookielaw-eu") . "</a>",
            'more_info' => "<a href='" . esc_url("https://www.cookielaw.eu/?utm_source=wp%20admin&utm_medium=plugin%20list") . "' target='_blank'>" . __("More info", "cookielaw-eu") . "</a>"
                ), $actions);
    }

    public function load_textdomain() {
        load_plugin_textdomain('cookielaw-eu', false, basename(dirname(__FILE__)) . '/languages/');
    }

    public function register_settings() {
        register_setting('cookielaw-options-group', 'cookielaw_api_key');
        register_setting('cookielaw-options-group', 'cookielaw_script_position');
        register_setting('cookielaw-options-group', 'cookielaw_language');
    }

    public function admin_menu() {
        add_options_page(__("CookieLaw.eu", "cookielaw-eu"), __("CookieLaw.eu", "cookielaw-eu"), 'manage_options', 'cookielaw-settings', array($this, 'settings_page'));
    }

    public function script_init() {
        if (get_option('cookielaw_script_position') == 'head') {
            add_action('wp_head', array($this, 'print_script'), 99);
        } else {
            add_action('wp_footer', array($this, 'print_script'), 99);
        }
    }

    public function print_script() {
        if (!get_option('cookielaw_api_key')) {
            echo "<!--" . __("CookieLaw.eu: No API key is defined. Go to Wordpress settings to set it.", "cookielaw-eu") . "-->";
            return;
        }
        if (file_exists($this->templates_path . "frontend.php")) {
            include($this->templates_path . "frontend.php");
        }
    }

    public function settings_page() {
        if (file_exists($this->templates_path . "admin.php")) {
            include($this->templates_path . "admin.php");
        }
    }

    static function get_instance() {
        if (static::$instance == null) {
            $instance = new self();
        }
        return $instance;
    }

}

CookieLaw_WP::get_instance();
