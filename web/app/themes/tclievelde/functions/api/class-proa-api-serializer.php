<?php

/**
 * Class Proa_API_Serializer
 *
 * Serializer for API objects with full search API data.
 */
class Proa_API_Serializer {

    /**
     * Returns the serialized API object.
     *
     * @param  Proa_API_Object $APIObject
     * @return array
     */
    public function serialize(Proa_API_Object $APIObject): array
    {
        return $this->toFormat($APIObject);
    }

    /**
     * Serializes and returns an API object with the full search data.
     *
     * @param  Proa_API_Object $APIObject
     * @return array
     */
    protected function toFormat(Proa_API_Object $APIObject): array
    {
        return [
            'object' => $APIObject->getAPIData(),
            'type'   => $APIObject->getObjectType(),
            'link'   => $APIObject->getLink(),
        ];
    }
}
