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

    public function render() {
        ob_start();
        ?>
        <div
            class="fb-page"
            data-href="https://www.facebook.com/xeisuzusaigon/"
            data-tabs="timeline"
            data-width=""
            data-height=""
            data-small-header="false"
            data-adapt-container-width="true"
            data-hide-cover="false"
            data-show-facepile="true"
        >
            <blockquote
                cite="https://www.facebook.com/xeisuzusaigon/"
                class="fb-xfbml-parse-ignore"
            >
                <a href="https://www.facebook.com/xeisuzusaigon/">Nhà Trọ Cần Thơ</a>
            </blockquote>
        </div>
        <?php
        return ob_get_clean();
    }
}
