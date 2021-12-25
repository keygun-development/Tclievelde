<?php

namespace Tclievelde\core\models;

use Tclievelde\core\Localization\LocalizedName;

/**
 * Interface CustomPostTypeInterface
 * @package Tclievelde\core
 */
interface CustomPostTypeInterface
{
    /**
     * @return string
     */
    public function getPostType(): string;

    /**
     * @return LocalizedName
     */
    public function getName(): LocalizedName;

    /**
     * @return array
     */
    public function getLabels(): array;

    /**
     * @return void
     */
    public function registerPostType(): void;
}
