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
        $selected_pages = array_map(function ($item) {
            return preg_replace('/[^\d\,\.]/', '', $item);
        }, $selected_pages);

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
        $layout->setOptions($this->options);

        return $layout->render();
    }

    public static function getStyleSupports()
    {
        return apply_filters('jankx/widget/renderer/page_selector/styles', array(
            'simple' => __('Simple', 'jankx')
        ));
    }
}
