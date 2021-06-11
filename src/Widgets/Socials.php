<?php
namespace Jankx\Widget\Widgets;

use WP_Widget;
use Jankx;
use Jankx\Template\Template;

class Socials extends WP_Widget
{
    public function __construct()
    {
        $options = array(
            'classname' => 'jankx-socials',
            'description' => __('Show your social networks from theme settings to frontend', 'jankx'),
        );

        parent::__construct(
            'jankx_socials',
            sprintf(
                '%s %s',
                Jankx::templateName(),
                __('Socials', 'jankx')
            ),
            $options
        );
    }

    public function form($instance) {

    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        if (isset($instance['title'])) {
            echo $args['before_title'];
                echo array_get($instance, 'title');
            echo $args['after_title'];
        }

        $engine = Template::getEngine(Jankx::ENGINE_ID);
        echo $engine->render('widget/socials');

        echo $args['after_widget'];
    }
}
