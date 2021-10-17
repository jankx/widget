<?php
namespace Jankx\Widget\Renderers;

use Jankx\TemplateEngine\Engine;
use Jankx\Widget\Constracts\Renderer;
use Jankx\TemplateAndLayout;

abstract class Base implements Renderer
{
    protected $templateEngine;

    protected $options = array();
    protected $layoutOptions = array();

    public function __toString()
    {
        return (string) $this->render();
    }

    public function setOption($optionName, $optionValue)
    {
        $this->options[$optionName] = $optionValue;
    }

    public function setOptions($options)
    {
        if (is_array($options)) {
            foreach ($options as $key => $val) {
                $method = preg_replace_callback(array('/^([a-z])/', '/[_|-]([a-z])/', '/.+/'), function ($matches) {
                    if (isset($matches[1])) {
                        return strtoupper($matches[1]);
                    }
                    return sprintf('set%s', $matches[0]);
                }, $key);

                if (method_exists($this, $method)) {
                    $this->$method($val);
                } else {
                    $this->setOption($key, $val);
                }
            }
        }
        return $this;
    }

    public function setLayoutOptions($options)
    {
        if (!is_array($options)) {
            return;
        }
        $this->layoutOptions = wp_parse_args(
            $options,
            $this->layoutOptions
        );
    }

    public function getLayoutOptions()
    {
        return $this->layoutOptions;
    }

    public static function prepare($args, $renderer = null)
    {
        if (is_null($renderer) || !is_a($renderer, Renderer::class)) {
            $renderer = new static();
        }
        return $renderer->setOptions($args);
    }

    public function setTemplateEngine($templateEngine)
    {
        if (is_a($templateEngine, Engine::class)) {
            $this->templateEngine = &$templateEngine;
        }
    }

    public function loadTemplate($templateName, $data = array(), $echo = false)
    {
        if (is_null($this->templateEngine)) {
            $this->templateEngine = TemplateAndLayout::getTemplateEngine();
        }
        return $this->templateEngine->render($templateName, $data, $echo);
    }
}
