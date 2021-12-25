<?php

namespace Tclievelde\core\api;

use WP_REST_Response;

/**
 * Class API_Response_Factory
 * @package Tclievelde\core\api
 */
class ApiResponseFactory
{
    /** @var mixed */
    private $data;

    /** @var string */
    private $status = 200;

    /** @var string */
    private string $message;

    /**
     * @param $data
     *
     * @return $this
     */
    public function setData($data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param string $status
     *
     * @return $this
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param string $message
     *
     * @return $this
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return WP_REST_Response
     */
    public function getResponse(): WP_REST_Response
    {
        if (!$this->data) {
            return $this->getNotFoundResponse();
        }

        $response = [
            'status' => $this->status,
            'data' => $this->data,
        ];

        if (!empty($this->message)) {
            $response['message'] = $this->message;
        }

        return new WP_REST_Response($response);
    }

    /**
     * @return WP_REST_Response
     */
    public function getNotFoundResponse(): WP_REST_Response
    {
        $response = [
            'status'  => 404,
        ];

        $response['message'] = $this->message
            ?? 'Geen resultaten gevonden';

        return new WP_REST_Response($response);
    }
}
