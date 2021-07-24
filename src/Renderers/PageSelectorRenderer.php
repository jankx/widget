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
        $selected_pages = array_get($this->options, 'pages', []);
        if (empty($selected_pages)) {
            return;
        }

        $args = array(
            'post_type' => 'page',
            'post__in' => $selected_pages,
            'orderby' => 'post__in',
            'order' => 'ASC'
        );
        return new WP_Query($args);
    }


    public function render()
    {
        $wp_query = $this->getWordPressQuery();
        if (!$wp_query) {
            return '';
        }

        $postLayoutManager = PostLayoutManager::getInstance(TemplateLoader::getTemplateEngine());
        $layout = $postLayoutManager->createLayout(
            array_get($this->options, 'layout'),
            $wp_query
        );

        return $layout->render();
    }
}
