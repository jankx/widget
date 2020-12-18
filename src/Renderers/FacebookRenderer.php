<?php
namespace Jankx\Widget\Renderers;

abstract class FacebookRenderer extends Base
{
    protected static $facebook_app_id;

    public function __construct()
    {
        static::loadFacebookAppId();
        static::writeFacebookSdkScript();
    }

    protected static function loadFacebookAppId()
    {
        if (!is_null(static::$facebook_app_id)) {
            return;
        }
        static::$facebook_app_id = '2120429251546497';
    }

    public static function _script() {
        ?>
        <div id="fb-root"></div>
        <script
            async
            defer
            crossorigin="anonymous"
            src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v9.0&appId=<?php echo static::$facebook_app_id; ?>&autoLogAppEvents=1"
            nonce="vceBT42E"
        >
        </script>
        <?php
    }

    public static function writeFacebookSdkScript()
    {
        if (is_null(static::$facebook_app_id)) {
            return;
        }
        add_action('wp_footer', array(__CLASS__, '_script'));
    }
}
