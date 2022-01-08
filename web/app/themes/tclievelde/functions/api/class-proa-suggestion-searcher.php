<?php

/**
 * Class Proa_Suggestion_Searcher
 *
 * Used to create an WP_REST_Response with the suggested search results.
 */
class Proa_Suggestion_Searcher extends Proa_Searcher {

    /**
     * Create a new Response document for the required search format.
     * Use the Proa_API_Suggestion_Serializer in order to get the suggested search result data from the Proa objects.
     *
     * @return Proa_API_Response_Document
     */
    protected function createResponseDocument()
    {
        return new Proa_API_Response_Document(new Proa_API_Serializer());
    }

    /**
     * Inserts the found Proa objects into the response document, based on given tag.
     * Use the method 'findByPostTitleLike' to only search on the post titles.
     *
     * @param string $proaClassName
     * @param string $tag
     */
    protected function addDocumentItems(string $proaClassName, string $tag) {
        $this->responseDocument->setAPIObjects($proaClassName::findByPostTitleLike($this->searchInput), $tag);
    }
}
