<?php

class CurrentQuery
{
    private static self $instance;

    public static function get(): self
    {
        return static::$instance ??= new static();
    }

    private QueryTransform $currentTemplate;

    private WP_Query $currentQuery;

    public function store(QueryTransform $template, WP_Query $query): self
    {
        $this->currentTemplate = $template;
        $this->currentQuery = $query;

        return $this;
    }

    public function getCurrentTemplate(): QueryTransform
    {
        return $this->currentTemplate;
    }

    public function getCurrentQuery(): WP_Query
    {
        return $this->currentQuery;
    }
}
