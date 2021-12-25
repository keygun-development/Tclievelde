<?php


namespace Tclievelde\Theme\TemplateParts\Nav;

use Tclievelde\helpers\DisplaysView;
use Tclievelde\helpers\newExpression;

/**
 * Class NavigationDesktopItem
 * @package Tclievelde\Theme\TemplateParts\Nav
 */
class NavigationDesktopItem extends NavigationItem
{
    /**
     * @return string
     */
    public function getView(): string
    {
        return sprintf(
            '<a href="%s" class="%s"><div class="header__nav-item__text">%s</div></a>',
            $this->url,
            $this->classes,
            $this->title
        );
    }
}
