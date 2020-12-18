<?php
namespace Jankx\Widget\Widgets\Facebook;

use WP_Widget;
use Jankx\Widget\Renderers\Facebook\PagePlugin as PagePluginRenderer;

class PagePlugin extends WP_Widget
{
    const WIDGET_ID = 'jankx-facebook-page-plugin';

    protected $renderer;

    public function __construct()
    {
        $options = array(
            'classname' => 'jankx-fb-pageplugin',
            'description' => __('Display Facebook page plugin support cached preview', 'jankx')
        );
        parent::__construct(
            static::WIDGET_ID,
            __('Facebook Page Plugin', 'jankx'),
            $options
        );
        $this->renderer = new PagePluginRenderer();
    }

    public function form($args)
    {
    }

    public function widget($args, $instance)
    {
        echo (string) $this->renderer;
    }
}
