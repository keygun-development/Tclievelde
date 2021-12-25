<?php

namespace Tclievelde\core\search;

/**
 * Class MatchesSearch
 * @package Tclievelde\Custom_Post_Types\Search
 */
interface SearchTermsInterface
{
    /**
     * @return SearchTermsInterface[]
     */
    public function getSearchTerms(): array;
}
