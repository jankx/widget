<?php
namespace Jankx\Widget\Renderers;

use WP_Query;
use Jankx\PostLayout\PostLayoutManager;

class PostsRenderer extends Base
{
    protected $categories = array();
    protected $tags = array();
    protected $options = array();

    protected $layout = PostLayoutManager::LIST;

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

    public function getQuery()
    {
        $args = array(
            'post_type' => 'post',
        );

        if (!empty($this->categories)) {
            $args['category__in'] = $this->categories;
        }
        if (!empty($this->tags)) {
            $args['tag__in'] = $this->tags;
        }

        $args['posts_per_page'] = array_get($this->options, 'limit', 10 );

        return apply_filters(
            'jankx_widget_post_renderer_make_query',
            new WP_Query($args),
            $this->options
        );
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

        return $postLayout->render();
    }
}