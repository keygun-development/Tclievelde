<?php
    namespace Tclievelde\Theme\TemplateParts\Nav;

/**
 * Class NavigationDesktop
 * @package Tclievelde\Theme\TemplateParts\Nav
 */
class NavigationDesktop extends Navigation
{
    /**
     * @return array
     */
    public function getItems(): array
    {
        return tclievelde_get_menu_items_with_children("header-menu");
    }

    /**
     * @return string
     */
    public function getStartView(): string
    {
        return '<nav class="header__nav" id="nav">';
    }

    /**
     * @return string
     */
    public function getEndView(): string
    {
        return '
        <a href="javascript:void(0);" class="header__hamburger"
           onclick="Tclievelde.toggleHamburger()">
            <i class="fa fa-bars"></i>
        </a></nav>';
    }

    /**
     * @param $nav_item
     *
     * @return string
     */
    public function getItemView($nav_item): string
    {
        if ($nav_item->child_items) {
            $output = '
                <div class="header__nav-item' . ( tclievelde_should_menu_item_highlight($nav_item->post_title) ? ' selected' : '' ) . '">
	                <a href="' . $nav_item->url . '" class="header__nav-item__text header__dropdown">
	                    <div class="header__nav-item__text">	' . $nav_item->post_title . '</div>
	                    <i class="fas fa-chevron-down"></i>
	                </a>
	
	                <div class="header__dropdown--content">';
            foreach ($nav_item->child_items as $child_item) {
                $output .= sprintf('<div>%s</div>', NavigationItem::of()
                    ->setTitle($child_item->title)
                    ->setUrl($child_item->url)
                    ->getView());
            }

            return $output . '
	                </div>
	            </div>';
        } else {
            return NavigationDesktopItem::of()
                ->setUrl($nav_item->url)
                ->setTitle($nav_item->title)
                ->addClass('header__nav-item')
                ->addClass((tclievelde_should_menu_item_highlight($nav_item->post_title) ? ' selected' : ''))
                ->getView();
        }
    }
}
