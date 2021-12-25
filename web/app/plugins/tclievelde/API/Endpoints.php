<?php

namespace Tclievelde\API;

use Tclievelde\API\endpoints\GetMatchesByID;

/**
 * Class Endpoints
 * @package Tclievelde\API
 */
class Endpoints
{
    /**
     * @return void
     */
    public function register(): void
    {
        (new GetMatchesByID)->register();
    }
}
