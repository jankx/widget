<?php
namespace Jankx\Widget\Renderers;

use Jankx;
use Jankx\Option\Helper;
use Jankx\Template\Template;

class SocialsRenderer extends Base
{
    protected $options = [
        'icon-style' => 'regular',
        'html-type' => 'svg'
    ];

    protected function getIcons() {
        $icons = [
            'facebook' => 'icons/facebook.svg',
            'twitter' => 'icons/twitter.svg',
            'instgram' => 'icons/instagram.svg',
            'tiktok' => 'icons/tiktok.svg',
            'youtube' => 'icons/youtube.svg'
        ];

        $fontIcons = [
            'facebook' => 'fa-brands fa-facebook',
            'twitter' => 'fa-brands fa-twitter',
            'instagram' => 'fa-brands fa-instagram',
            'tiktok' => 'fa-brands fa-tiktok',
            'youtube' => 'fa-brands fa-youtube'
        ];

        return apply_filters('jankx/socials/icons', [
            'svg' => $icons,
            'font' => $fontIcons,
        ]);
    }

    protected function resolveIcon($name, $listIcons, $type) {}

    public static function getIconType() {
        return apply_filters('jankx/socials/icons/style', 'font');
    }

    public function render() {
        $engine = Template::getEngine(Jankx::ENGINE_ID);

        $socials        = [];
        $socialIcons    = $this->getIcons();
        $socialSupports = apply_filters('jankx/socials/list', ['facebook', 'twitter', 'instagram', 'youtube', 'tiktok']);

        foreach($socialSupports as $socialName) {
            $optionKey = sprintf('%s_url', $socialName);
            $value = Helper::getOption($optionKey);
            if (!empty($value)) {
                $socials[$socialName]['url'] = $value;
                $socials[$socialName]['icon'] = $this->resolveIcon($socialName, $socialIcons, static::getIconType());
                $socials[$socialName]['target'] = '_blank';
            }
        }

        $templateFile = static::getIconType() == 'font' ? 'widget/socials' : 'widget/socials-type-image';

        echo $engine->render(
            $templateFile,
            [
                'socials' => apply_filters('jankx/socials/data', $socials, $socialSupports, $socialIcons),
                'icon_type' => static::getIconType(),
            ]
        );
    }
}
