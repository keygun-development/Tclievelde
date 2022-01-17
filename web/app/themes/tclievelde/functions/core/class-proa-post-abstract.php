<?php

namespace functions\core;

use functions\api\Proa_API_Object;

/**
 * Class Proa_Post_Abstract
 */
abstract class Proa_Post_Abstract extends Proa_Object implements Proa_API_Object
{
    protected const SNIPPET_LENGTH = 120;

    /**
     * @return string
     */
    abstract static function getIdentifier(): string;

    /**
     * @param WP_Post $post
     *
     * @return static
     */
    abstract static function parse($post): self;

    /**
     * @param  array  $arguments
     * @return array
     */
    protected static function retrieve(array $arguments): array
    {
        $arguments['post_type'] = static::getIdentifier();
        return get_posts($arguments);
    }

    /**
     * Returns objects related to the current object.
     *
     * @param integer $amount The amount of objects to return.
     *
     * @return array
     */
    public function getRelated($amount = 3): array
    {
        return static::parse_many(static::retrieve([
            'posts_per_page' => $amount,
            'orderby'        => 'rand',
            'post__not_in'   => [ $this->getPost()->ID ],
        ]));
    }

    /**
     * Finds objects like itself by the specified meta query.
     *
     * @see https://codex.wordpress.org/Class_Reference/WP_Meta_Query
     *
     * @param  array  $meta_query
     * @param int   $limit
     *
     * @return array
     */
    public static function findBy(array $arguments, $limit = 6): array
    {
        return static::parse_many(static::retrieve(array_merge($arguments, ['limit' => $limit])));
    }

    /**
     * @param  string $title
     * @param  int    $limit
     * @param  array  $arguments
     * @return array
     */
    public static function findByPostTitleLike($title, $limit = 6, $arguments = []): array
    {
        $arguments = array_merge($arguments, [
            'posts_per_page'   => $limit,
            'post_type'        => static::getIdentifier(),
            'meta_query'       => $arguments,
            'posts_title_like' => $title,
        ]);

        add_filter('posts_where', 'posts_title_like', 10, 2);
        $query = new WP_Query($arguments);
        remove_filter('posts_where', 'posts_where'. 10, 2);

        return static::parse_many($query->get_posts());
    }

    /**
     * @return WP_Post
     */
    public function getPost(): WP_Post
    {
        return $this->getWPObject();
    }

    /**
     * @param WP_Post $post
     *
     * @return $this
     */
    public function setPost($post): self
    {
        return $this->setWPObject($post);
    }

    /**
     * @return string
     */
    public function getObjectType(): string
    {
        return static::getIdentifier();
    }

    /**
     * @return array
     */
    public function getAPISuggestionData(): array
    {
        return ['suggestion' => get_the_title($this->getPost())];
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return get_post_permalink($this->getPost());
    }

    /**
     * Returns the data for an API retrieve request.
     *
     * @return array
     */
    public function getAPIData(): array
    {
        return [
            'title' => get_the_title($this->getPost()),
            'content_snippet' => $this->getSnippet(),
            'image' => proa_get_proxy_to_image($this->getImageUrl()),
            'date' => get_the_date('d-m-Y', $this->getPost()),
        ];
    }

    /**
     * Returns the post's image url.
     *
     * @param  string  $size
     * @return string
     */
    public function getImageUrl(string $size = 'original'): string
    {
        return get_the_post_thumbnail_url($this->getPost(), $size);
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

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->getPost()->post_title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->getPost()->post_content;
    }
}
