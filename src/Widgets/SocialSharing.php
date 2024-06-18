<?php

namespace Jankx\Widget\Widgets;

use WP_Widget;
use Jankx\Widget\Renderers\SocialSharingRenderer;

class SocialSharing extends WP_Widget
{
    public function form($instance)
    {
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo __('Title'); ?></label>
            <input type="text" id="<?php echo $this->get_field_id('title'); ?>" class="widefat" value="<?php echo array_get($instance, 'title'); ?>" />
        </p>
        <?php
    }

    public function widget($args, $instance)
    {
        echo $args['before_widget'];
        if (array_get($instance, 'title')) {
            echo $args['before_title'];
            echo array_get($instance, 'title');
            echo $args['after_title'];
        }

        $renderer = new SocialSharingRenderer();
        echo $renderer->render();
        echo $args['after_widget'];
    }
}
