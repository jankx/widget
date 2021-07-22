<?php
namespace Jankx\Widget\Renderers;

use WP_Query;
use Jankx\TemplateLoader;
use Jankx\PostLayout\PostLayoutManager;
use Jankx\PostLayout\Layout\ListLayout;

class PageSelectorRenderer extends Base
{
    public function getWordPressQuery()
    {
        $args = array(
            'post_type' => 'page',
            'post__in' => array_get($this->options, 'pages', []),
        );
        return new WP_Query($args);
    }


    public function render()
    {
        $postLayoutManager = PostLayoutManager::getInstance(TemplateLoader::getTemplateEngine());
        $layout = $postLayoutManager->createLayout(
            array_get($this->options, 'layout'),
            $this->getWordPressQuery()
        );

        return $layout->render();
    }
}
