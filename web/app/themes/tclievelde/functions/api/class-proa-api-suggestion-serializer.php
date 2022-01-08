<?php

/**
 * Class Proa_API_Suggestion_Serializer
 *
 * Same serializer as Proa_API_Serializer, but retrieves the suggested API data instead of the full API data.
 */
class Proa_API_Suggestion_Serializer extends Proa_API_Serializer {

    /**
     * Serializes and returns an API object with the suggested search data.
     *
     * @param  Proa_API_Object $APIObject
     * @return array
     */
    protected function toFormat(Proa_API_Object $APIObject): array
    {
        return [
            'object' => $APIObject->getAPISuggestionData(),
            'type'   => $APIObject->getObjectType(),
            'link'   => $APIObject->getLink(),
        ];
    }
}
