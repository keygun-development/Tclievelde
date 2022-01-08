<?php

/**
 * Class Proa_API_Searcher
 *
 * Used to create an WP_REST_Response with the full search results.
 */
class Proa_Searcher {

    /** @var Proa_API_Response_Document */
    protected $responseDocument;

    /** @var string */
    protected $searchInput;

    /**
     * APISearchSuggestion constructor.
     * @param string $searchInput
     */
    public function __construct(string $searchInput)
    {
        $this->searchInput = $searchInput;
        $this->responseDocument = $this->createResponseDocument();
    }

    /**
     * Creates a WP_REST_Response from the response document.
     *
     * @return WP_REST_Response
     */
    public function getResponse()
    {
        $this->populateDocument();

        return $this->responseDocument->getResponse();
    }

    /**
     * Create a new Response document for the required search format.
     * Use the Proa_API_Serializer in order to get the full search result data from the Proa objects.
     *
     * @return Proa_API_Response_Document
     */
    protected function createResponseDocument()
    {
        return new Proa_API_Response_Document(new Proa_API_Serializer());
    }

    /**
     * Populate the response document with found Proa objects, grouped by Proa object type.
     *
     * @return void
     */
    private function populateDocument() {
        $this->addDocumentItems(Proa_Participant::class, 'participant');
        $this->addDocumentItems(Proa_Expert::class, 'expert');
        $this->addDocumentItems(Proa_Technique::class, 'technique');
        $this->addDocumentItems(Proa_Post::class, 'news');
    }

    /**
     * Inserts the found Proa objects into the response document, based on given tag.
     *
     * @param string $proaClassName
     * @param string $tag
     */
    protected function addDocumentItems(string $proaClassName, string $tag) {
        $this->responseDocument->setAPIObjects($proaClassName::search($this->searchInput), $tag);
    }
}
