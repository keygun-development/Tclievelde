<?php


namespace Tclievelde\Theme\TemplateParts\Nav;

use Tclievelde\helpers\DisplaysView;
use Tclievelde\helpers\NewExpression;

/**
 * Class NavigationItem
 * @package Tclievelde\Theme\TemplateParts\Nav
 */
class NavigationItem
{
    use NewExpression,
        DisplaysView;

    /**
     * @var string
     */
    protected string $title;

    /**
     * @var string
     */
    protected string $url;

    /**
     * @var string
     */
    protected string $classes = '';

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return NavigationItem
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return NavigationItem
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getClasses(): string
    {
        return $this->classes;
    }

    /**
     * @param string $classes
     *
     * @return NavigationItem
     */
    public function setClasses(string $classes): self
    {
        $this->classes = trim($classes);

        return $this;
    }

    /**
     * @param string $class
     *
     * @return $this
     */
    public function addClass(string $class): self
    {
        return $this->setClasses($this->classes . ' ' . $class);
    }

    /**
     * @return string
     */
    public function getView(): string
    {
        return sprintf('<a href="%s" class="%s"><div>%s</div></a>', $this->url, $this->classes, $this->title);
    }
}
