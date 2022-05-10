<?php

namespace Tclievelde\Theme\TemplateParts\Nav;

/**
 * Class NavigationMobile
 * @package Tclievelde\Theme\TemplateParts\Nav
 */
class NavigationMobile extends Navigation
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
        return '<nav class="header__hamburger-nav" id="mobile-nav">';
    }

    /**
     * @return string
     */
    public function getEndView(): string
    {
        return '<div class="hamburger__header"><a href="/uitloggen"><div>Uitloggen</div></a></div>
<a id="bars" class="header__hamburger" onclick="toggleHamburger()">
                    <div class="one"></div>
                    <div class="two"></div>
                    <div class="three"></div>
                </a></nav>';
    }

    /**
     * @param $item
     *
     * @return string
     */
    public function getItemView($item): string
    {
        if ($item->child_items) {
            $output = '
		    <div>
                <a 
                href="' . $item->url . '"
                class="hamburger__header">
					' . $item->post_title . '
                </a>

                <div class="hamburger__links">';
            foreach ($item->child_items as $child_item) {
                $output .= NavigationItem::of()
                    ->setTitle($child_item->title)
                    ->setUrl($child_item->url)
                    ->setClasses('hamburger__link')
                    ->getView();
            }
            return $output . '</div></div>';
        } else {
            return '<div class="hamburger__header">' . NavigationItem::of()
                    ->setUrl($item->url)
                    ->setTitle($item->title)
                    ->getView() . '</div>';
        }
    }
}
