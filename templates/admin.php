<?php
if (!defined('ABSPATH')) {
    die("Oh, c'mon!");
}
?>

<div class="wrap" id="contain">
    <h1><?php _e('CookieLaw.eu settings', 'cookielaw-eu'); ?></h1>
    <form id="tadvadmin" method="POST" action="options.php">
        <?php settings_fields('cookielaw-options-group'); ?>
        <?php do_settings_sections('cookielaw-options-group'); ?>
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="api-key"><?php _e('API Key', 'cookielaw-eu') ?> *</label></th>
                    <td>
                        <input name="cookielaw_api_key" type="text" id="api-key" value="<?php echo esc_attr(get_option('cookielaw_api_key')); ?>" required class="regular-text">
                        <p class="description" id="tagline-description"><?php echo sprintf(__('Please go to <a href=\'%s\' target=\'_blank\'>Cookielaw.eu</a> to obtain a new API key.', 'cookielaw-eu'), esc_url("https://www.cookielaw.eu/?utm_source=wp%20admin&utm_medium=settings%20page")) ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="cookielaw_script_position"><?php _e('Script position', 'cookielaw-eu') ?> *</label></th>
                    <td>
                        <select name="cookielaw_script_position" id="cookielaw_script_position">
                            <option value='head' <?php echo get_option('cookielaw_script_position') == 'head' ? "selected='selected'" : null; ?>><?php _e('WP Head', 'cookielaw-eu') ?></option>
                            <option value='footer' <?php echo get_option('cookielaw_script_position') == 'footer' ? "selected='selected'" : null; ?>><?php _e('WP Footer', 'cookielaw-eu') ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="cookielaw_language"><?php _e('Language', 'cookielaw-eu') ?> *</label></th>
                    <td>
                        <select name="cookielaw_language" id="cookielaw_language">
                            <option value='user' <?php echo get_option('cookielaw_language') == 'user' || !get_option('cookielaw_language') ? "selected='selected'" : null; ?>><?php _e('Based on user browser', 'cookielaw-eu') ?></option>
                            <option value='wp' <?php echo get_option('cookielaw_language') == 'wp' ? "selected='selected'" : null; ?>><?php _e('Based on Wordpress locale', 'cookielaw-eu') ?></option>
                        </select>
                        <p class="description" id="tagline-description"><?php echo __('Defines which language should use Cookielaw.eu service for displaying the consent windows', 'cookielaw-eu') ?></p>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php submit_button(); ?>
    </form>
</div>