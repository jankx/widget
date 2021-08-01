<?php
namespace Jankx\Widget\Renderers;

use Jankx\Widget\Constracts\Renderer;

abstract class Base implements Renderer
{
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
        $this->layoutOptions = $options;
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
}
