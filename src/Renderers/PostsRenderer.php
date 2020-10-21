<?php
namespace Jankx\Widget\Renderers;

use WP_Query;
use Jankx\PostLayout\PostLayoutManager;

class PostsRenderer extends Base
{
    protected $categories = array();
    protected $tags = array();
    protected $options = array();

    protected $layout = PostLayoutManager::LIST_LAYOUT;

    public function setCategories($value)
    {
        $this->categories = $value;
    }
    public function setTags($value)
    {
        $this->tags = $value;
    }

    public function setLayout($value)
    {
        $this->layout = $value;
    }

    public function validateTaxonomies() {
        // `none` value's Elementor
        if (is_string($this->tags) && $this->tags == 'none') {
            $this->tags = false;
        }
        if (is_string($this->categories) && $this->categories == 'none') {
            $this->categories = false;
        }
    }

    public function getQuery()
    {
        $args = array(
            'post_type' => 'post',
        );
        $this->validateTaxonomies();

        if (!empty($this->categories)) {
            $args['category__in'] = $this->categories;
        }
        if (!empty($this->tags)) {
            $args['tag__in'] = $this->tags;
        }

        $args['posts_per_page'] = array_get($this->options, 'posts_per_page', 10);

        return apply_filters(
            'jankx_widget_post_renderer_make_query',
            new WP_Query($args),
            $this->options
        );
    }

    public function excerptLenght($length) {
        if (isset($this->options['excerpt_length'])) {
            return $this->options['excerpt_length'];
        }
        return $length;
    }

    public function render()
    {
        $layoutManager = PostLayoutManager::getInstance();
        $layoutCls     = $layoutManager->getLayoutClass($this->layout);
        if (empty($layoutCls)) {
            _e('Please choose your post layout', 'jankx');
            return;
        }
        $postLayout    = new $layoutCls($this->getQuery());

        $postLayout->setOptions($this->options);

        if (array_get($this->options, 'show_excerpt', false)) {
            add_filter('excerpt_length', array($this, 'excerptLenght'));
        }
        $renderedLayout = $postLayout->render();
        if (array_get($this->options, 'show_excerpt', false)) {
            remove_filter('excerpt_length', array($this, 'excerptLenght'));
        }

        return $renderedLayout;
    }
}
