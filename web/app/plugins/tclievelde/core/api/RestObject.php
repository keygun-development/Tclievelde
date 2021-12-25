<?php

namespace Tclievelde\core\api;

use Tclievelde\core\Attributes\AttributesTrait;

/**
 * Class RestObject
 * @package Tclievelde\API
 */
class RestObject implements RestObjectInterface
{
    use AttributesTrait;

    /** @var int */
    private int $identifier;

    /** @var string */
    private string $object_type;

    /** @var string */
    private string $link;

    /**
     * API_Object constructor.
     *
     * @param int    $identifier
     * @param string $object_type
     * @param string $link
     * @param array  $attributes
     */
    public function __construct(int $identifier, string $object_type, array $attributes, string $link)
    {
        $this->identifier  = $identifier;
        $this->object_type = $object_type;
        $this->link        = $link;
        $this->attributes  = $attributes;
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @inheritDoc
     */
    public function getObjectType(): string
    {
        return $this->object_type;
    }

    /**
     * @inheritDoc
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * The attribute field names depends on the connected
     *
     * @return array
     */
    public function getFieldNames(): array
    {
        return array_keys($this->attributes);
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'id'   => $this->identifier,
            'type' => $this->object_type,
            'data' => $this->attributes,
            'link' => $this->link,
        ];
    }
}
