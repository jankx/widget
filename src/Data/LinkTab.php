<?php
namespace Jankx\Widget\Data;

class LinkTab
{
    protected $url;
    protected $title;
    protected $isExternal = false;
    protected $nofollow = false;
    protected $isActive = false;
    protected $attributes = array();

    public function __construct($title, $url = '#', $isExternal = false, $nofollow = false, $attributes = array())
    {
        $this->setTitle($title);
        $this->setUrl($url);
        $this->setIsExternal($isExternal);
        $this->setNofollow($nofollow);
        $this->setAttributes($attributes);
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function setIsExternal($isExternal)
    {
        $this->isExternal = $isExternal;
    }

    public function setNofollow($nofollow)
    {
        $this->nofollow = $nofollow;
    }

    public function setAttributes($attributes)
    {
        if (is_array($attributes)) {
            $this->attributes = $attributes;
        }
    }

    public function addAttribute($attributeName, $value)
    {
        $this->attributes[$attributeName] = $value;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getIsExternal()
    {
        return $this->isExternal;
    }

    public function getNofollow()
    {
        return $this->nofollow;
    }

    public function getAttributes()
    {
        if ($this->isExternal) {
            $this->attributes['target'] = '_blank';
        }
        if ($this->nofollow) {
            $this->attributes['rel'] = 'nofollow';
        }

        return $this->attributes;
    }

    public function setActive($isActive)
    {
        $this->isActive = (boolean) $isActive;
    }

    public function isActive()
    {
        return $this->isActive;
    }
}
