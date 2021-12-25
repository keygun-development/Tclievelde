<?php

namespace Tclievelde\core\customTaxonomies;

use Tclievelde\core\Actionable;

/**
 * Interface CustomTaxonomyInterface
 * @package posts
 */
interface CustomTaxonomyInterface extends Actionable
{
    /**
     * @return string
     */
    public function getTaxonomyType(): string;

    /**
     * @return array
     */
    public function getLabels(): array;

    /**
     * @return void
     */
    public function registerTaxonomy(): void;
}
