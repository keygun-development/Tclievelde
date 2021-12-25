<?php

namespace Tclievelde\customPostTypes\search;

use Tclievelde\core\attributes\AttributesInterface;
use Tclievelde\core\search\acf\AcfSearchTermIn;
use Tclievelde\core\search\acf\AcfSearchTermLike;
use Tclievelde\core\search\SearchTermsInterface;
use Tclievelde\core\search\SearchTrait;
use Tclievelde\Core\search\SetsAttributesByArray;

/**
 * Class MatchesById
 * @package Tclievelde\customPostTypes\search
 * @property array matches_ids
 */
class MatchesById implements SearchTermsInterface, AttributesInterface
{
    use SearchTrait,
        SetsAttributesByArray;

    /**
     * MatchesSearch constructor.
     */
    public function __construct()
    {
        $this->search_terms = [
            'match_ids' => new AcfSearchTermLike('matches'),
        ];
    }
}
