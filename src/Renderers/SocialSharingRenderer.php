<?php
namespace Jankx\Widget\Renderers;

class SocialSharingRenderer extends Base
{
    public function render()
    {
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
