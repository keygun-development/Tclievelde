<?php

namespace Tclievelde\Theme\TemplateParts\Nav\SearchBar;

use Tclievelde\Theme\TemplateParts\Nav\SearchBar\LongSearchBar;

/**
 * Class ShortSearchBar
 * @package Tclievelde\Theme\TemplateParts\Nav\SearchBar
 */
class ShortSearchBar extends LongSearchBar
{
    /**
     * @return string
     */
    public function getView(): string
    {
        return '
        <div class="header__margin-top--btn head-hero head-hero--height-auto">
            <div class="container d-flex justify-content-center align-items-center">
        
                <div class="head-hero__search head-hero__search--small">
                    <div class="search search--no-padding search--background-transperant">
                        <div class="search__title">
                        </div>
                        <form action="' . $this->url . '" class="search__form">
                            <div class="search__field input__text--subtle">
                                <input name="zoekterm" class="search__input" placeholder="Waar ben je naar op zoek?"
                                       type="text" value="' . ($_GET['zoekterm'] ?? '') . '">
                                <button class="button button--black px-4" type="submit"><i
                                        class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
        
            </div>
        </div>';
    }
}
