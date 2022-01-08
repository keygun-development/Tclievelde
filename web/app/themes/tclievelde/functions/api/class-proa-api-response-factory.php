<?php

require_once __DIR__ . '/class-proa-api-object.php';

/**
 * Class APIResponseFactory
 *
 * Factory to build API Responses.
 */
class Proa_API_Response_Factory {

    /**
     * Creates and returns a WP_REST_Response based on the given response data.
     *
     * @param  array $responseData
     * @return WP_REST_Response
     */
    public static function response(array $responseData)
    {
        $response = new WP_REST_Response($responseData);

        if (count($responseData) === 0) {
            $response->set_status(404);
        }

        $response->set_status(200);

        return $response;
    }

    /**
     * Creates and returns an error WP_REST_Response.
     *
     * @param  string $message
     * @param  int $status
     * @return WP_REST_Response
     */
    public static function error(string $message, int $status)
    {
        $responseData = [
            'error' => [
                'message' => $message,
                'status'  => $status,
            ]
        ];

        $response = new WP_REST_Response($responseData);
        $response->set_status($status);

        return $response;
    }
}
