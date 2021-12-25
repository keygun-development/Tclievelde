<?php

namespace Tclievelde\core\models;

use InvalidArgumentException;
use Tclievelde\core\customPosts\CustomPostInterface;
use WP_Post;
use WP_Query;

/**
 * Implements default custom post type instantiation for interface.
 * @see Custom_Post_Type_Instantiator_Interface
 *
 * Trait CustomPostInstantiation
 * @package posts
 */
trait CustomPostInstantiation
{

    /**
     * @var WP_Query|null
     */
    private ?WP_Query $wp_query;

    /**
     * @return string
     */
    abstract public function getPostType(): string;

    /**
     * @return string
     */
    abstract protected function getPostClass(): string;

    /**
     * @return ModelInterface
     */
    abstract protected function getModel(): ModelInterface;

    /**
     * @param WP_Query $wp_query
     */
    protected function setWpQuery(WP_Query $wp_query): void
    {
        $this->wp_query = $wp_query;
    }

    /**
     * @return WP_Query|null
     */
    public function getWpQuery(): ?WP_Query
    {
        return $this->wp_query;
    }

    /**
     * @param array $post_arr
     *
     * @return CustomPostInterface
     */
    public function create(array $post_arr = []): CustomPostInterface
    {
        $class = $this->getPostClass();

        // Force (override) using the correct post type
        $post_arr['post_type'] = $this->getPostType();

        /** @var CustomPostInterface $custom_post */
        return new $class(
            $this->getModel(),
            get_post(wp_insert_post($post_arr, true)),
            null,
        );
    }

    /**
     * @param WP_Post|string|int $post
     * @param WP_Query|null $query
     *
     * @return CustomPostInterface|null
     */
    public function fromPost($post, ?WP_Query $query = null): ?CustomPostInterface
    {
        /** @var WP_Post $post */
        $post = get_post($post);
        if (! $post) {
            throw new InvalidArgumentException('Post with the given identifier doesn\'t exist!');
        }

        if ($post->post_type !== $this->getPostType()) {
            return null;
        }

        $class = $this->getPostClass();

        /** @var CustomPostInterface $customPost */
        $customPost = new $class($this, $post, $query);

        if (! $customPost instanceof CustomPostInterface) {
            throw new InvalidArgumentException('This trait ("' . self::class . '") can only be used on classes which are implementing interface "Custom_Post_Interface" ');
        }

        return $customPost;
    }

    /**
     * @param array $arguments
     *
     * @return CustomPostInterface|null
     */
    public function first(array $arguments): ?CustomPostInterface
    {
        $arguments['posts_per_page'] = 1;

        $posts = $this->getFromArguments($arguments);

        return (empty($posts))
            ? null
            : $posts[0];
    }

    /**
     * @param int[] $ids
     * @param array $arguments
     *
     * @return CustomPostInterface[]
     */
    public function fromIDs(array $ids, array $arguments = []): array
    {
        if (empty($ids)) {
            $arguments['post__in'] = [0]; // Force the WP_Query to return 0 results.
                                          // Using an empty array will return the
                                          // recent posts instead.
        } else {
            $arguments['post__in'] = $ids;
        }

        return $this->getFromArguments($arguments);
    }

    /**
     * @param array $arguments
     *
     * @return array
     */
    public function all(array $arguments = []): array
    {
        $arguments['posts_per_page'] = -1;

        return $this->getFromArguments($arguments);
    }

    /**
     * @param array|null $specified_arguments
     *
     * @return CustomPostInterface[]
     *
     * @see https://developer.wordpress.org/reference/classes/wp_query/parse_query/
     */
    public function getFromArguments(?array $specified_arguments = null, bool $get_posts = true): array
    {
        /**
         * It should not be possible to change this key/value,
         * because the method @see CustomPostInstantiation::fromPost() relies on the
         * return value of method @see CustomPostInstantiation::get_post_type().
         * An exception will be thrown if they do not match.
         *
         * Change the implementation for method @see CustomPostInstantiation::get_post_type()
         * inside the class that uses this trait if you want to dynamically specify the post type.
         */
        $unchangeable_arguments = [
            'post_type' => $this->getPostType(),
        ];

        $default_arguments = [
            'posts_per_page' => 5, // WordPress default.
        ];

        /**
         * Specified arguments will overwrite the default arguments.
         */
        $arguments = ( is_array($specified_arguments) )
            ? array_merge($default_arguments, $specified_arguments)
            : $default_arguments;

        if (! $get_posts) {
            $arguments['fields'] = 'ids';
        }

        /**
         * Unchangeable arguments will override the current arguments.
         */
        $arguments = array_merge($arguments, $unchangeable_arguments);

        $wp_query = new WP_Query($arguments);
        $this->setWpQuery($wp_query);

        $posts = $wp_query->get_posts();

        if (! $get_posts) {
            return $posts;
        }

        return array_map(fn(WP_Post $post) => $this->fromPost($post, $wp_query), $posts);
    }
}
