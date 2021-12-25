<?php

namespace Tclievelde\core\search;

use Tclievelde\core\attributes\AttributesInterface;

/**
 * Trait SearchGroupTrait
 * @package Tclievelde\customPostTypes\search
 */
trait SearchTrait
{
    /**
     * @var SearchTermInterface[]
     */
    private array $search_terms;

    /**
     * @param string $name
     *
     * @return SearchTermInterface
     */
    public function getSearchTerm(string $name): SearchTermInterface
    {
        return $this->search_terms[$name];
    }

    /**
     * @return SearchTermInterface[]
     */
    public function getSearchTerms(): array
    {
        return $this->search_terms;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->getAttribute($name)->get_value();
    }

    /**
     * @param string $name
     * @param $value
     *
     * @return AttributesInterface
     */
    public function __set(string $name, $value)
    {
        return $this->setAttribute($name, $value);
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return self
     */
    public function setAttribute(string $name, $value): AttributesInterface
    {
        if ($this->has($name)) {
            $search_term = $this->getSearchTerm($name);
            $search_term->setValue($value);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getAttribute(string $name)
    {
        return $this->getSearchTerm($name)->getValue();
    }

    /**
     * @inheritDoc
     */
    public function getAttributes(): array
    {
        return array_map(function (SearchTermInterface $search_term) {
            return $search_term->getValue();
        }, $this->getSearchTerms());
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->getAttributes());
    }
}
