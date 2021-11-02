<?php

namespace Tclievelde\Theme\TemplateParts\Nav\SearchBar;

/**
 * Class LongSearchBar
 * @package Tclievelde\Theme\TemplateParts\Nav\SearchBar
 */
class LongSearchBar extends SearchBar
{

    /**
     * @return string
     */
    public function getView(): string
    {
        return '
        <div class="head-hero"
             style="background-image: url(' . sprintf('%s/assets/images/home-bg.png', get_template_directory_uri()) . ')">
            <div class="head-hero__overlay">
                <div class="container justify-content-end align-items-center">
    
                    <div class="head-hero__search">
                        <div class="search search--no-padding search--background-transperant">
                            <div class="search__title">
                            </div>
                            <form action="' . $this->url . '" class="search__form">
                                <div class="search__field">
                                    <input name="zoekterm" class="search__input"
                                           placeholder="Waar ben je naar op zoek?"
                                           type="text" value="' .
               ( $_GET['zoekterm'] ?? '' ) . '">
                                    <input class="button search_button--padding-large" value="Zoeken" type="submit">
                                </div>
                            </form>
                        </div>
                    </div>
    
                </div>
            </div>
        </div>
        ';
    }
}
