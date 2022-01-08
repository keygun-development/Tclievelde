<?php

require_once __DIR__ . '/class-proa-api-object.php';

/**
 * Class Proa_API_Response_Document
 *
 * Used to return WP_REST_Responses with formatted, serialized data based on stored API objects.
 */
class Proa_API_Response_Document {

    /**
     * Current serialized objects.
     *
     * @var array of APIItems
     */
    private $serializedObjects = [];

    /** @var Proa_API_Serializer */
    protected $serializer;

    /**
     * APIResponseFactory constructor.
     *
     * @param Proa_API_Serializer $serializer
     */
    public function __construct(Proa_API_Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * Serializes and stores a new Proa_API_Object on the given tag.
     *
     * @param  Proa_API_Object $APIObject
     * @param  string          $tag
     * @return self
     */
    public function addAPIObject(Proa_API_Object $APIObject, string $tag)
    {
        if (!array_key_exists($tag, $this->serializedObjects[$tag])) {
            $this->serializedObjects[$tag] = [];
        }

        $this->serializedObjects[$tag][] = $this->serializer->serialize($APIObject);
        return $this;
    }

    /**
     * Serializes and stores the array of Proa_API_Object on the given tag.
     *
     * @param  array  $APIObjects
     * @param  string $tag
     * @return self
     */
    public function addAPIObjects(array $APIObjects, string $tag)
    {
        if (!array_key_exists($tag, $this->serializedObjects[$tag])) {
            $this->serializedObjects[$tag] = [];
        }

        foreach ($APIObjects as $APIObject) {
            if ($APIObject instanceof Proa_API_Object) {
                $this->serializedObjects[$tag][] = $this->serializer->serialize($APIObject);
            }
        }

        return $this;
    }

    /**
     * Serializes and stores the given array of Proa_API_Object on the given tag.
     *
     * @param  array  $APIObjects
     * @param  string $tag
     * @return self
     */
    public function setAPIObjects(array $APIObjects, string $tag)
    {
        $this->serializedObjects[$tag] = [];

        foreach ($APIObjects as $APIObject) {
            if ($APIObject instanceof Proa_API_Object) {
                $this->serializedObjects[$tag][] = $this->serializer->serialize($APIObject);
            }
        }

        return $this;
    }

    /**
     * Creates and returns a new WP_REST_Response from the stored data.
     * The format of the stored data depends on the method 'getResponseData'.
     *
     * @return WP_REST_Response
     */
    public function getResponse(): WP_REST_Response
    {
        return Proa_API_Response_Factory::response($this->getResponseData());
    }

    /**
     * Returns the objects in the specified format.
     *
     * @return array
     */
    protected function getResponseData(): array
    {
        return [
            'data' => $this->serializedObjects
        ];
    }
}
