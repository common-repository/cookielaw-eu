<?php
/**
 * CookieLaw.eu // Shortcodes CLASS
 *
 * @package   CookieLaw.eu\WP
 * @copyright Copyright (C) 2018, Swypelab SRL - info@swypelab.com
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3 or higher
 */
if (!defined('ABSPATH')) {
    die("Oh, c'mon!");
}

class CookieLaw_WP_Shortcodes {

    static $instance = null;

    public function __construct() {

        add_shortcode('cl_embedded_policy', array($this, 'cl_embedded_policy'));
    }

    public function cl_embedded_policy() {
        $id = uniqid("cl");
        ob_start();
        ?>
        <div id='<?php echo esc_attr($id) ?>'></div>
        <script type="text/javascript">
            window.addEventListener('load', function () {
                Cookielaw.embed_policy(document.getElementById('<?php echo esc_attr($id) ?>'));
            });
        </script>
        <?php
        return ob_get_clean();
    }

    static function get_instance() {
        if (static::$instance == null) {
            $instance = new self();
        }
        return $instance;
    }

}

CookieLaw_WP_Shortcodes::get_instance();
