<?php
namespace Jankx\Widget\Widgets;

use WP_Widget;
use Jankx;
use Jankx\GlobalVariables;

class CollapaseNavMenu extends WP_Widget
{
    public function __construct()
    {
        $options = array(
            'name' => sprintf(__('%s Collapase Menu', 'jankx'), Jankx::templateName()),
        );

        return parent::__construct(
            'jankx_collapase_menu',
            __('Collapase Menu', 'jankx'),
            $options
        );
    }

    public function widget($args, $instance)
    {
    }
}
