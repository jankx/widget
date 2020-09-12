<?php
namespace Jankx\Widget\Widget;

use WP_Widget;

class Posts extends WP_Widget
{
    public function __construct()
    {
        $options = array(
            'classname' => 'jankx-posts',
            'description' => __('Show posts on your site with many filters and features.', 'jankx')
        );
        parent::__construct('jankx_posts', __('Jankx Posts', 'jankx'), $options);
    }

    public function widget()
    {
    }
}
