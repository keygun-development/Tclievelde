<?php

namespace Tclievelde\core\models;

use InvalidArgumentException;
use Tclievelde\core\customPosts\CustomPostInterface;
use WP_Post;
use WP_Query;

/**
 * Trait CustomPostTypeInstantiatorInterface
 * @package posts
 */
interface CustomPostTypeInstantiatorInterface
{

    /**
     * @return WP_Query|null
     */
    public function getWpQuery(): ?WP_Query;

    /**
     * @param array $post_arr
     *
     * @return CustomPostInterface
     */
    public function create(array $post_arr = []): CustomPostInterface;

    /**
     * @param WP_Post|string|int $post
     *
     * @return CustomPostInterface|null
     * @throws InvalidArgumentException
     */
    public function fromPost($post): ?CustomPostInterface;

    /**
     * @param array $arguments
     *
     * @return CustomPostInterface|null
     */
    public function first(array $arguments): ?CustomPostInterface;

    /**
     * @return CustomPostInterface[]
     */
    public function all(): array;

    /**
     * @param int[] $ids
     * @param array $arguments
     *
     * @return CustomPostInterface[]
     */
    public function fromIDs(array $ids, array $arguments = []): array;

    /**
     * @param array|null $specified_arguments
     *
     * @return CustomPostInterface[]|int[]
     */
    public function getFromArguments(?array $specified_arguments = null, bool $get_posts = true): array;
}
