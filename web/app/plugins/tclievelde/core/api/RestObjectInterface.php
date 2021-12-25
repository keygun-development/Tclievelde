<?php

namespace Tclievelde\core\api;

use JsonSerializable;
use Tclievelde\core\attributes\AttributesInterface;

/**
 * Interface RestObjectInterface
 * @package Tclievelde\API
 */
interface RestObjectInterface extends AttributesInterface, JsonSerializable
{
    /**
     * @return string
     */
    public function getIdentifier(): string;

    /**
     * @return string
     */
    public function getObjectType(): string;

    /**
     * @return string
     */
    public function getLink(): string;
}
