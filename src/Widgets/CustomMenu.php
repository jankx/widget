<?php
namespace Jankx\Widget\Widgets;

use WP_Widget;
use Jankx\GlobalVariables;

class CustomMenu extends WP_Widget
{
    public function __construct()
    {
        $options = array(
            'name' => sprintf(
                __('%s Custom Menu', 'jankx'),
                GlobalVariables::get('theme.short_name', 'Jankx')
            ),
        );

        return parent::__construct(
            'jankx_custom_menu',
            __('Custom Menu', 'jankx'),
            $options
        );
    }

    public function widget($args, $instance)
    {
    }
}
