<?php

namespace Tclievelde\core\search\acf;

use Tclievelde\core\search\SearchTermInterface;
use Tclievelde\core\search\SearchTermTrait;

/**
 * Class ACFSearchTermLessThan
 * @package Tclievelde\core\search\acf
 */
class AcfSearchTermLike implements SearchTermInterface
{
    use SearchTermTrait;

    /**
     * @return array
     */
    public function parse(): array
    {
        return [
            'key'     => $this->key,
            'value'   => $this->value,
            'compare' => 'LIKE'
        ];
    }
}
