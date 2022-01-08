<?php

require_once __DIR__.'/CurrentQuery.php';

class QueryTransform
{
    /**
     * @var Closure[]
     */
    private array $predicates;

    /**
     * @var array
     */
    private array $filters = [];

    private bool $useDefaultArchiveQuery = true;

    private int $postsPerPage = 9;

    public static function builder(): self
    {
        return new QueryTransform();
    }

    /**
     * @param  Closure  $closure
     * @return $this
     */
    public function when(Closure $closure): self
    {
        $this->predicates[] = $closure;
        return $this;
    }

    /**
     * @return $this
     */
    public function whenMainQuery(): self
    {
        return $this->when(fn(WP_Query $query) => $query->is_main_query());
    }

    /**
     * @return $this
     */
    public function whenArchive(): self
    {
        return $this->when(fn(WP_Query $query) => $query->is_archive());
    }

    /**
     * @return $this
     */
    public function whenPostType(string $type): self
    {
        return $this->when(fn(WP_Query $query) => $query->query_vars['post_type'] === $type);
    }

    /**
     * @param  bool  $useDefaultArchiveQuery
     * @return self
     */
    public function useDefaultArchiveQuery(bool $useDefaultArchiveQuery): self
    {
        $this->useDefaultArchiveQuery = $useDefaultArchiveQuery;
        return $this;
    }

    /**
     * @param  int  $itemsPerPage
     * @return self
     */
    public function postsPerPage(int $itemsPerPage): self
    {
        $this->postsPerPage = $itemsPerPage;

        if ($this->postsPerPage !== 9) {
            $this->useDefaultArchiveQuery(false);
        }

        return $this;
    }

    public function filterByCategory(string $slug, string $type = 'category'): self
    {
        $this->filters[] = [
            'taxonomy' => $type,
            'field' => 'slug',
            'terms' => $slug,
        ];

        return $this;
    }

    public function build(): self
    {
        if (!$this->useDefaultArchiveQuery) {
            add_action('pre_get_posts', function (WP_Query $query) {
                if ($this->predicateAll($query)) {
                    $this->overrideQuery($query);
                    CurrentQuery::get()->store($this, $query);
                }
            });
        }

        return $this;
    }

    private function predicateAll(...$params): bool
    {
        foreach ($this->predicates as $predicate) {
            if (!$predicate->call($this, ...$params)) {
                return false;
            }
        }

        return true;
    }

    private function overrideQuery(WP_Query $query)
    {
        $query->query_vars['posts_per_page'] = $this->postsPerPage;
        $query->set('tax_query', $this->filters);
    }
}
