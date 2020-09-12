<?php
namespace Jankx\Widget\Renderers;

use Jankx\Widget\Constracts\Renderer;

abstract class Base implements Renderer
{
    public function __toString()
    {
        return (string) $this->render();
    }

    public static function prepare($args)
    {
        $renderer = new static();
        
        if (is_array($args)) {
            foreach ($args as $key => $val) {
                $method = preg_replace_callback(array('/^([a-z])/', '/[_|-]([a-z])/', '/.+/'), function ($matches) {
                    if (isset($matches[1])) {
                        return strtoupper($matches[1]);
                    }
                    return sprintf('set%s', $matches[0]);
                }, $key);

                if (method_exists($renderer, $method)) {
                    $renderer->$method($val);
                }
            }
        }

        return $renderer;
    }
}
