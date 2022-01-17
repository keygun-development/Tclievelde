<?php

namespace functions\customposts;

use functions\core\Proa_Post_Abstract;
use Generator;

class Proa_Post extends Proa_Post_Abstract
{
    /** @var WP_Post */
    private $subtechnique;

    /** @var array */
    private $authors;

    /**
     * @return WP_Post
     */
    public function get_subtechnique(): WP_Post
    {
        return $this->subtechnique;
    }

    /**
     * @param WP_Post|null $subtechnique
     *
     * @return Proa_Post
     */
    public function set_subtechnique(?WP_Post $subtechnique): self
    {
        $this->subtechnique = $subtechnique;
        return $this;
    }

    /**
     * @return array
     */
    public function get_authors(): array
    {
        return $this->authors;
    }

    /**
     * @param  array|mixed  $authors
     * @return Proa_Post
     */
    public function set_authors($authors): Proa_Post
    {
        if (is_array($authors)) {
            $this->authors = array_map(function (array $item) {
                return $item['author'];
            }, $authors);
        } else {
            $this->authors = [];
        }

        return $this;
    }

    /**
     * @return string
     */
    public function get_authors_formatted(): string
    {
        return empty($this->authors)
            ? sprintf('<a href="%s">%s</a>', '/over-nppl/', 'NPPL')
            : implode(', ', $this->authors);
    }

    /**
     * @return string
     */
    public static function getIdentifier(): string
    {
        return 'post';
    }

    /**
     * @param WP_Post $post
     *
     * @return Proa_Post
     * @throws Exception
     */
    public static function parse($post): self
    {
        if ($post->post_type !== 'post') {
            throw new Exception('Invalid post type given. Expected post.');
        }

        $storedPost = new Proa_Post();

        $post_technique = get_field('post_techniques', $post->ID)[0] ?? null;

        if ($post_technique !== null) {
            $post_technique = get_post($post_technique);
        }

        $storedPost->set_subtechnique($post_technique);
        $storedPost->set_authors(get_field('author'));

        $storedPost->setPost($post);

        return $storedPost;
    }

    /**
     * @return Proa_Dashboard|null
     * @throws Exception
     */
    public function get_dashboard(): ?Proa_Dashboard
    {
        if ($this->subtechnique == null) {
            return null;
        }

        $parsed_subtechnique = Proa_Subtechnique::parse($this->subtechnique);

        return Proa_Dashboard::parse($parsed_subtechnique->getParentDashboard());
    }
}
