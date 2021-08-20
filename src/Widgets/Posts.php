<?php
namespace Jankx\Widget\Widgets;

use WP_Widget;
use Jankx\Widget\Renderers\PostsRenderer;
use Jankx\PostLayout\PostLayoutManager;
use Jankx\TemplateLoader;

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
                'thumbnail_position' => array_get($instance, 'thumbnail_position', 5),
                'show_postdate' => array_get($instance, 'show_post_date', 'no') === 'yes',
                'columns'  => array_get($instance, 'columns', 4),
                'rows'  => array_get($instance, 'rows', 1),
            ));
        if (array_get($instance, 'post_layout')) {
            $postsRenderer->setLayout(array_get($instance, 'post_layout'));
        }
            echo $postsRenderer;
        echo array_get($args, 'after_widget');
    }

    protected function get_post_layout_options($current)
    {
        $layouts = PostLayoutManager::getLayouts(array(
            'field' => 'names'
        ));
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('post_layout'); ?>"><?php _e('Post Layouts', 'jankx'); ?></label>
            <select
                name="<?php echo $this->get_field_name('post_layout'); ?>"
                id="<?php echo $this->get_field_id('post_layout'); ?>"
                class="widefat"
            >
                <option value=""><?php _e('Default'); ?></option>
                <?php foreach ($layouts as $layout => $name) : ?>
                    <option value="<?php echo $layout; ?>" <?php echo selected($layout, $current); ?>><?php echo $name; ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <?php
    }

    public function form($instance)
    {
        $thumbnail_positions = array(
            'top' => __('Top'),
            'left' => __('Left'),
            'right' => __('Right'),
        );
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
            <label for="<?php echo $this->get_field_id('thumbnail_position'); ?>"><?php _e('Thumbnail Position', 'jankx'); ?></label>
            <select
                name="<?php echo $this->get_field_name('thumbnail_position'); ?>"
                id="<?php echo $this->get_field_id('thumbnail_position'); ?>"
                class="widefat"
            >
                <option value=""><?php _e('Default'); ?></option>
                <?php foreach ($thumbnail_positions as $thumbnail_position => $position) : ?>
                    <option value="<?php echo $thumbnail_position; ?>" <?php echo selected($thumbnail_position, array_get($instance, 'thumbnail_position', '')); ?>><?php echo $position; ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('show_post_date') ?>">
                <input
                    type="checkbox"
                    id="<?php echo $this->get_field_id('show_post_date') ?>"
                    name="<?php echo $this->get_field_name('show_post_date'); ?>"
                    <?php checked('yes', array_get($instance, 'show_post_date', 'no')); ?>
                    value="yes"
                />
                <?php _e('Show post date', 'jankx'); ?>
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('posts_per_page') ?>"><?php _e('Number of items', 'jankx'); ?></label>
            <input
                type="number"
                id="<?php echo $this->get_field_id('posts_per_page') ?>"
                name="<?php echo $this->get_field_name('posts_per_page'); ?>"
                value="<?php echo array_get($instance, 'posts_per_page', 5) ?>"
            />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('columns') ?>"><?php _e('Columns', 'jankx'); ?></label>
            <input
                type="number"
                class="widefat"
                id="<?php echo $this->get_field_id('columns') ?>"
                name="<?php echo $this->get_field_name('columns'); ?>"
                value="<?php echo array_get($instance, 'columns', 5) ?>"
            />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('rows') ?>"><?php _e('Rows', 'jankx'); ?></label>
            <input
                type="number"
                class="widefat"
                id="<?php echo $this->get_field_id('rows') ?>"
                name="<?php echo $this->get_field_name('rows'); ?>"
                value="<?php echo array_get($instance, 'rows', 5) ?>"
            />
        </p>
        <?php
    }
}
