<?php
namespace Jankx\Widget\Constracts;

interface Renderer
{
    public function render();

    public function setTemplateEngine($templateEngine);
}
