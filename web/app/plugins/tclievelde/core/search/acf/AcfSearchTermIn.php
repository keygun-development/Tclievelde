<?php

namespace Tclievelde\core\search\acf;

use Tclievelde\core\search\SearchTermInterface;
use Tclievelde\core\search\SearchTermTrait;

/**
 * Class AcfSearchTermIn
 * @package Tclievelde\core\search\acf
 */
class AcfSearchTermIn implements SearchTermInterface
{
    use SearchTermTrait;

    /**
     * @inheritDoc
     */
    public function parse(): array
    {
        $value = $this->value;

        if (empty($value)) {
            $value = [0]; // Force the WP_Query to return 0 results.
                          // Using an empty array will return the
                          // recent posts instead.
        }

        return [
            'key'     => $this->key,
            'value'   => $value,
            'compare' => 'IN'
        ];
    }
}
