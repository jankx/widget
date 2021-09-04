<?php
namespace Jankx\Widget\Renderers;

use WP_Query;
use WP_Post;
use Jankx\TemplateLoader;
use Jankx\PostLayout\PostLayoutManager;
use Jankx\PostLayout\Layout\ListLayout;

class PostsRenderer extends PostTypePostsRenderer
{
    protected $taxonomies = array();
    protected $categories = array();
    protected $tags = array();
    protected $options = array(
        'data_preset' => '',
    );
    protected $wp_query;
    protected $layout = ListLayout::LAYOUT_NAME;

    public function __construct($wp_query = null)
    {
        if (!is_null($wp_query)) {
            $this->wp_query = $wp_query;
        }
    }

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

    public function setTaxonomies($taxonomies)
    {
        if (!in_array($taxonomies)) {
            return;
        }
        $this->taxonomies = $taxonomies;
    }

    public function validateTaxonomies()
    {
        // `none` value's Elementor
        if (is_string($this->tags) && $this->tags == 'none') {
            $this->tags = false;
        }
        if (is_string($this->categories) && $this->categories == 'none') {
            $this->categories = false;
        }
    }

    public function createDataPresetArgs(&$args)
    {
        if (($data_preset = array_get($this->options, 'data_preset'))) {
            switch ($data_preset) {
                case 'related':
                    $queried_object = get_queried_object();
                    if (is_a($queried_object, WP_Post::class)) {
                        $currentPostType = array_get($this->options, 'post_type', 'post');
                        if ($currentPostType && $currentPostType !== $queried_object->post_type) {
                            return false;
                        }

                        $args['post_type'] = $queried_object->post_type;
                        $args['post__not_in'] = array($queried_object->ID);

                        if ($queried_object->post_type === 'post') {
                            $this->categories = wp_get_post_terms($queried_object->ID, 'category', array('fields' => 'ids'));
                            $this->tags = wp_get_post_terms($queried_object->ID, 'post_tag', array('fields' => 'ids'));
                        }
                    }
                    break;
                case 'recents':
                    $args['orderby'] = 'date';
                    $argc['order'] = 'DESC';
                    break;
            }
        }

        return true;
    }

    public function generateWordPressQuery()
    {
        if (is_null($this->wp_query)) {
            $args = array(
                'post_type' => array_get($this->options, 'post_type', 'post'),
            );
            $this->validateTaxonomies();
            if (!$this->createDataPresetArgs($args)) {
                return;
            }

            if (!empty($this->categories)) {
                $args['category__in'] = $this->categories;
            }
            if (!empty($this->tags)) {
                $args['tag__in'] = $this->tags;
            }

            if (($post_format = array_get($this->options, 'post_format', 'standard')) !== 'standard') {
                $args['tax_query'][] = array(
                    'taxonomy' => 'post_format',
                    'field' => 'slug',
                    'terms' => sprintf('post-format-%s', $post_format)
                );
            }

            $args['posts_per_page'] = array_get($this->options, 'posts_per_page', 10);

            // Sort posts
            $orderBy = array_get($this->options, 'orderby', 'none');
            if ($orderBy && $orderBy !== 'none') {
                $args['orderby'] = $orderBy;
                $args['order'] = array_get($this->options, 'order', 'ASC');
            }

            $this->wp_query = apply_filters(
                'jankx_widget_post_renderer_make_query',
                new WP_Query($args),
                $this->options
            );
        }
        return $this->wp_query;
    }

    public function setQuery($query)
    {
        if (is_a($query, \WP_Query::class)) {
            $this->wp_query = $query;
        }
    }

    public function excerptLenght($length)
    {
        if (isset($this->options['excerpt_length'])) {
            return $this->options['excerpt_length'];
        }
        return $length;
    }

    protected function createPostMetaFeatures()
    {
        $metas = array();
        if (array_get($this->options, 'show_postdate')) {
            $metas['post_date'] = false;
        }
        return $metas;
    }

    public function render()
    {
        $wp_query = $this->generateWordPressQuery();
        if (is_null($wp_query) || !$wp_query->have_posts()) {
            return;
        }

        $layoutManager = PostLayoutManager::getInstance(
            TemplateLoader::getTemplateEngine()
        );
        $postLayout     = $layoutManager->createLayout($this->layout, $wp_query);
        if (empty($postLayout)) {
            _e('Please choose your post layout', 'jankx');
            return;
        }

        if (!isset($this->options['post_meta_features'])) {
            $this->setOption(
                'post_meta_features',
                $this->createPostMetaFeatures()
            );
        }
        $postLayout->setOptions($this->options);

        add_filter('excerpt_length', array($this, 'excerptLenght'));
        $renderedLayout = $postLayout->render(false);
        remove_filter('excerpt_length', array($this, 'excerptLenght'));

        return $renderedLayout;
    }
}
