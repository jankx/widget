<?php
namespace Jankx\Widget\Renderers;

class SocialSharingRenderer extends Base
{
    public function render()
    {
        $pre = apply_filters('jankx/socials/sharing/pre', null, $this);
        if (!is_null($pre)) {
            return $pre;
        }

        jankx_social_share_buttons(array(
            'fbButton' => 'Facebook',
            'tw' => 'Twitter',
            'pinterest' => 'Pinterest',
            'linkedin' => 'Linkedin',
            'whatsapp' => 'WhatsApp',
            'viber' => 'Viber',
            'email' => 'Email',
            'telegram' => 'Telegram',
            'line' => 'Line'
        ));
    }
}
