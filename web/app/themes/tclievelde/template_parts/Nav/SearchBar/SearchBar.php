<?php


namespace Tclievelde\Theme\TemplateParts\Nav\SearchBar;

use Tclievelde\helpers\DisplaysView;
use Tclievelde\helpers\newExpression;

/**
 * Class SearchBar
 * @package Tclievelde\Theme\TemplateParts\Nav\SearchBar
 */
abstract class SearchBar
{
    use newExpression,
        DisplaysView;

    /**
     * @var string
     */
    protected string $url = '#';

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
     * @return SearchBar
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }
}
