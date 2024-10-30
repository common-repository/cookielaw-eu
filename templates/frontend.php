<?php
if (!defined('ABSPATH')) {
    die("Oh, c'mon!");
}
?>
<script>
    (function (c, o, k, i, e, s) {
        e = c.createElement(o);
        e.async = !0;
        e.src = k + '?t=' + i;
<?php if (get_option('cookielaw_language') == 'wp') { ?>
            e.src += '&l=<?php echo esc_attr(get_locale()) ?>';
<?php } ?>
        s = c.getElementsByTagName(o)[0];
        s.parentNode.insertBefore(e, s);
    })(document, 'script', 'https://api.cookielaw-script.it/<?php echo urlencode(trim(get_option('cookielaw_api_key'))) ?>.js', 'wp');
</script>