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

    public function setShowImage($value)
    {
        $this->options['show_image'] = $value;
    }
    public function setShowExpert($value)
    {
        $this->options['show_excerpt'] = $value;
    }
    public function setCategories($value)
    {
        $this->categories = $value;
    }
    public function setTags($value)
    {
        $this->tags = $value;
    }
    public function setHeaderText($value)
    {
        $this->options['header_text'] = $value;
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
        return new WP_Query(
            $args
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
