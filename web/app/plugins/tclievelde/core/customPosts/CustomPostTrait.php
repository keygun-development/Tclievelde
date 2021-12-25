<?php

namespace Tclievelde\core\customPosts;

use Tclievelde\core\models\ModelInterface;
use WP_Post;
use WP_Query;

/**
 * Trait Custom_Post_Constructor
 * @package Tclievelde\core\models
 */
trait CustomPostTrait
{
    /** @var ModelInterface */
    protected $model;

    /** @var WP_Post */
    protected WP_Post $wp_post;

    /**
     * Used WP_Query instance to retrieve this object.
     *
     * @var WP_Query|null
     */
    protected ?WP_Query $query;

    /**
     * Custom_Post_Trait constructor.
     *
     * @param ModelInterface $model
     * @param WP_Post $wp_post
     * @param WP_Query|null $query
     */
    public function __construct(ModelInterface $model, WP_Post $wp_post, ?WP_Query $query = null)
    {
        $this->model   = $model;
        $this->wp_post = $wp_post;
        $this->query = $query;
    }

    /**
     * @return ModelInterface
     */
    public function getModel(): ModelInterface
    {
        return $this->model;
    }

    /**
     * @return WP_Post
     */
    public function getWpPost(): WP_Post
    {
        return $this->wp_post;
    }

    /**
     * @return WP_Query|null
     */
    public function getUsedQuery(): ?WP_Query
    {
        return $this->query;
    }

    /**
     * @inheritDoc
     */
    public function getFieldNames(): array
    {
        return $this->model->getAcfFieldNames();
    }
}
