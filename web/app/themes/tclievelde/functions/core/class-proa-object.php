<?php

namespace functions\core;

use Generator;
use WP_Post;
use WP_Query;

/**
 * Class Proa_Post
 */
abstract class Proa_Object implements Proa_Base_Properties {
    use Proa_Retrievable_Object;

    /**
     * @var object
     */
    private object $wp_object;

    /**
     * @return string
     */
    abstract static function getIdentifier(): string;

    /**
     * @param WP_Post|WP_Term $wp_object
     *
     * @return static
     */
    abstract static function parse( $wp_object ): self;

    /**
     * @param  array  $posts
     * @return Generator
     */
    public static function parse_many_posts_iterator(array $posts): Generator {
        foreach ($posts as $post) {
            yield (static::class)::parse($post);
        }
    }

    /**
     * @param  WP_Post[]  $posts
     * @return static[]
     */
    public static function parse_many($posts = []): array {
        if (!$posts) {
            return [];
        }

        if (!is_array($posts)) {
            $posts = [$posts];
        }

        return iterator_to_array(static::parse_many_posts_iterator($posts));
    }

    /**
     * Returns all instances of the current post type.
     *
     * @return static[]
     */
    public static function all(): array {
        return static::findBy([], -1 );
    }

    /**
     * Returns objects related to the current object.
     *
     * @param integer $amount The amount of objects to return.
     *
     * @return static[]
     */
    public function getRelated( int $amount = 3 ): array {
        return static::parse_many(static::retrieve([
            'posts_per_page' => $amount,
            'orderby'        => 'rand',
            'post_type'      => static::getIdentifier(),
            'post__not_in'   => [ $this->getPost()->ID ],
        ]));
    }

    /**
     * Finds objects like itself by the specified meta query.
     *
     * @see https://codex.wordpress.org/Class_Reference/WP_Meta_Query
     *
     * @param  array  $meta_query
     * @param  int    $limit
     *
     * @return static[]
     */
    public static function findBy( array $meta_query, int $limit = 6 ): array {
        return static::parse_many(static::retrieve([
            'posts_per_page' => $limit,
            'post_type'      => static::getIdentifier(),
            'meta_query'     => $meta_query,
        ]));
    }

    /**
     * @param  string  $name
     * @param  array  $meta_query
     * @param  int  $limit
     * @return static[]
     */
    public static function findByName( string $name, array $meta_query, int $limit = 6 ): array {
        return static::parse_many(static::retrieve([
            'name' => $name,
            'posts_per_page' => $limit,
            'post_type'      => static::getIdentifier(),
            'meta_query'     => $meta_query,
        ]));
    }

    /**
     * @param  string  $slug
     * @param  array  $meta_query
     * @param  int  $limit
     * @return mixed
     */
    public static function findBySlug( string $slug, array $meta_query, int $limit = 6 ): array {
        return static::parse_many(static::retrieve([
            'slug' => $slug,
            'posts_per_page' => $limit,
            'post_type'      => static::getIdentifier(),
            'meta_query'     => $meta_query,
        ]));
    }

    /**
     * @param  array  $meta_query
     * @return static[]
     */
    public static function getRandomPostTypeObject( array $meta_query ): array {
        return static::parse_many(static::retrieve([
            'posts_per_page' => '1',
            'meta_query'     => $meta_query,
            'orderby'		 => 'rand'
        ]));
    }

    /**
     * @param  string $title
     * @param  int    $limit
     * @param  array  $arguments
     * @return array
     */
    public static function findByPostTitleLike( string $title, int $limit = 6, array $arguments = [] ): array {
        $arguments = [
            'posts_per_page'   => $limit,
            'post_type'        => static::getIdentifier(),
            'meta_query'       => $arguments,
            'posts_title_like' => $title,
        ];

        add_filter( 'posts_where', 'posts_title_like', 10, 2 );
        $query = new WP_Query($arguments);
        remove_filter( 'posts_where', 'posts_where'. 10, 2 );

        return static::parse_many($query->get_posts());
    }

    /**
     * Searches and returns a list of objects like itself by the given search parameter.
     *
     * @param  $search
     * @param  int $limit
     * @param  array $meta_query
     * @return array
     */
    public static function search( $search, int $limit = 6, array $meta_query = [] ): array {
        return static::parse_many(static::retrieve([
            'posts_per_page'   => $limit,
            'post_type'        => static::getIdentifier(),
            'meta_query'       => $meta_query,
            's' => $search,
        ]));
    }

    /**
     * @return object
     */
    public function getWPObject(): object {
        return $this->wp_object;
    }

    /**
     * @param object $wp_object
     *
     * @return $this
     */
    public function setWPObject( $wp_object ): self {
        $this->wp_object = $wp_object;

        return $this;
    }
    /**
     * Returns the post content with HTML stripped out.
     *
     * @return string
     */
    public function getContentText(): string
    {
        return wp_filter_nohtml_kses($this->getPost()->post_content);
    }

    /**
     * Returns the snippet of a content.
     * If the content exceeds the snippet length, the returned snipped has '...' prepended.
     *
     * @return string
     */
    public function getSnippet(): string
    {
        $snippet = substr($this->getContentText(), 0, Proa_Post::SNIPPET_LENGTH);

        return (strlen($this->getContentText()) > Proa_Post::SNIPPET_LENGTH) ?
            $snippet . '...' : $snippet;
    }
}