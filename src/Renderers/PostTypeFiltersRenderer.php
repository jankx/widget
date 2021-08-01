<?php
namespace Jankx\Widget\Renderers;

use WP_Query;
use Jankx\PostLayout\PostLayoutManager;
use Jankx\TemplateLoader;

class PostTypeFiltersRenderer extends Base
{
    protected $postType = 'post';
    protected $filters = array();
    protected $options = array(
        'posts_per_page' => 8,
    );
    protected $layoutOptions = array(
        'columns' => 4,
    );

    protected function setPostType()
    {
    }

    protected function generateWordPressQuery()
    {
        $args = array(
            'post_type' => 'project',
            'posts_per_page' => array_get($options, 'posts_per_page', 8),
        );

        return new WP_Query($args);
    }

    public function addFilter()
    {
    }

    public function render()
    {
        $postLayoutManager = PostLayoutManager::getInstance(TemplateLoader::getTemplateEngine());
        $postLayout = $postLayoutManager->createLayout(
            'card',
            $this->generateWordPressQuery()
        );
        $postLayout->setOptions($this->layoutOptions);

        $postLayout->render();
    }
}
