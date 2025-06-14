<?php

namespace Jankx\Widget\Constracts;

if (!defined('ABSPATH')) {
    exit('Cheatin huh?');
}

interface Renderer
{
    public function render();

    public function setTemplateEngine($templateEngine);
}
