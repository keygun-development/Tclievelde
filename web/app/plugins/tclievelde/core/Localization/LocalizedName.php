<?php

namespace Tclievelde\core\Localization;

/**
 * Class LocalizedName
 * @package Tclievelde\core\Localization
 */
class LocalizedName
{
    /** @var string */
    private $singular;

    /** @var string */
    private $plural;

    /**
     * @return string
     */
    public function getSingular(): string
    {
        return $this->singular;
    }

    /**
     * @return string
     */
    public function getPlural(): string
    {
        return $this->plural;
    }

    /**
     * Localized_Name constructor.
     *
     * @param string $singular_key
     * @param string $singular_plural
     * @param string $domain
     */
    public function __construct(string $singular_key, string $singular_plural, string $domain)
    {
        $this->singular = __($singular_key, $domain);
        $this->plural   = __($singular_plural, $domain);
    }
}
