<?php
namespace Jankx\Widget\Widgets;

use WP_Widget;
use Jankx\Widget\Renderers\PostsRenderer;
use Jankx\PostLayout\PostLayoutManager;

class Posts extends WP_Widget
{
    public function __construct()
    {
        $options = array(
            'classname' => 'jankx-posts',
            'description' => __('Show posts on your site with many filters and features.', 'jankx')
        );
        parent::__construct(
            'jankx_posts',
            sprintf(__('%s Posts', 'jankx'), \Jankx::templateName()),
            $options
        );
    }

    public function widget($args, $instance)
    {
        echo array_get($args, 'before_widget');
        if (!empty($instance['title'])) {
            echo array_get($args, 'before_title');
            echo $instance['title'];
            echo array_get($args, 'after_title');
        }
            $postsRenderer = PostsRenderer::prepare(array(
                'posts_per_page' => array_get($instance, 'posts_per_page', 5),
            ));
        if (array_get($instance, 'post_layout')) {
            $postsRenderer->setLayout(array_get($instance, 'post_layout'));
        }
            echo $postsRenderer;
        echo array_get($args, 'after_widget');
    }

    protected function get_post_layout_options($current)
    {
        $postLayoutManager = PostLayoutManager::getInstance();
        $layouts = $postLayoutManager->getLayouts();
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('post_layout'); ?>"><?php _e('Post Layouts', 'jankx'); ?></label>
            <select
                name="<?php echo $this->get_field_name('post_layout'); ?>"
                id="<?php echo $this->get_field_id('post_layout'); ?>"
                class="widefat"
            >
                <option value=""><?php _e('Default'); ?></option>
                <?php foreach ($layouts as $layout => $args) : ?>
                    <option value="<?php echo $layout; ?>" <?php echo selected($layout, $current); ?>><?php echo array_get($args, 'name'); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <?php
    }

    public function form($instance)
    {
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title'); ?></label>
            <input
                type="text"
                class="widefat"
                id="<?php echo $this->get_field_id('title'); ?>"
                name="<?php echo $this->get_field_name('title'); ?>"
                value="<?php echo array_get($instance, 'title'); ?>"
            />
        </p>
        <?php $this->get_post_layout_options(array_get($instance, 'post_layout')); ?>
        <p>
            <label for="<?php echo $this->get_field_id('posts_per_page') ?>"><?php _e('Number of items', 'jankx'); ?></label>
            <input
                type="number"
                id="<?php echo $this->get_field_id('posts_per_page') ?>"
                name="<?php echo $this->get_field_name('posts_per_page'); ?>"
                value="<?php echo array_get($instance, 'posts_per_page', 5) ?>"
            />
        </p>
        <?php
    }
}
