<?php
namespace Jankx\Widget\Renderers\Facebook;

use Jankx\Widget\Renderers\FacebookRenderer;

class PagePlugin extends FacebookRenderer
{
    protected $href;
    protected $width;
    protected $height;
    protected $tabs;
    protected $hide_cover;
    protected $show_facepile;
    protected $hide_cta;
    protected $small_header;
    protected $adapt_container_width;
    protected $lazy;

    public function render()
    {
        if (is_null(static::$facebook_app_id) || empty($this->href)) {
            return '';
        }

        ob_start();
        ?>
        <div
            class="fb-page"
            data-href="<?php echo $this->href; ?>"
            data-tabs="timeline"
            data-width=""
            data-height=""
            data-small-header="false"
            data-adapt-container-width="true"
            data-hide-cover="false"
            data-show-facepile="true"
        >
            <blockquote
                cite="<?php echo $this->href; ?>"
                class="fb-xfbml-parse-ignore"
            >
                <a href="<?php echo $this->href; ?>"><?php bloginfo('name'); ?></a>
            </blockquote>
        </div>
        <?php
        return ob_get_clean();
    }
}