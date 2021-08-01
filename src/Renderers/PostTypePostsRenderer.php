<?php
namespace Jankx\Widget\Renderers;

use WP_Query;
use Jankx\PostLayout\PostLayoutManager;
use Jankx\TemplateLoader;
use Jankx\PostLayout\Layout\Card;

class PostTypePostsRenderer extends Base
{
    protected $featuredMetaKey;
    protected $featuredMetaValue;

    protected $options = array(
        'layout' => 'card',
        'post_type' => 'post',
        'posts_per_page' => 10,
    );
    protected $layoutOptions = array(
        'columns' => 4
    );

    public function setFeaturedMetaKey($key)
    {
        if ($key) {
            $this->featuredMetaKey = $key;
        }
    }

    public function setFeaturedMetaValue($value)
    {
        if ($value) {
            $this->featuredMetaValue = $value;
        }
    }

    protected function generateWordPressQuery()
    {
        $args = array(
            'post_type' => array_get($this->options, 'post_type', 'post'),
            'posts_per_page' => array_get($this->options, 'posts_per_page', 10),
        );

        if ($this->featuredMetaKey) {
            $featuredMetaQuery = array(
                'key' => $this->featuredMetaKey,
            );
            if (empty($this->featuredMetaValue)) {
                $featuredMetaQuery['compare'] = 'EXISTS';
            } else {
                $featuredMetaQuery['value'] = $this->featuredMetaValue;
                $featuredMetaQuery['compare'] = '=';
            }
            $args['meta_query'][] = $featuredMetaQuery;
        }

        return new WP_Query($args);
    }

    public function render()
    {
        $postLayoutManager = PostLayoutManager::getInstance(TemplateLoader::getTemplateEngine());
        if (!$postLayoutManager) {
            return;
        }

        $layout = $postLayoutManager->createLayout(
            array_get($this->options, 'layout', Card::LAYOUT_NAME),
            $this->generateWordPressQuery()
        );
        $layout->setOptions($this->layoutOptions);

        return $layout->render(false);
    }
}
