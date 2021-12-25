<?php

namespace Tclievelde\core\customPosts;

use Tclievelde\core\attributes\AttributesInterface;
use Tclievelde\core\attributes\ExternalAttributesInterface;
use Tclievelde\core\models\ModelInterface;
use WP_Post;

/**
 * Interface ModelInterface
 * @package posts
 */
interface CustomPostInterface extends
    AttributesInterface,
    ExternalAttributesInterface,
    \JsonSerializable
{
    /**
     * Custom_Post_Interface constructor.
     *
     * @param ModelInterface $model
     * @param WP_Post $post
     */
    public function __construct(ModelInterface $model, WP_Post $post);

    /**
     * @return ModelInterface
     */
    public function getModel(): ModelInterface;

    /**
     * @return array
     */
    public function getFieldNames(): array;

    /**
     * @return WP_Post
     */
    public function getWpPost(): WP_Post;
}
