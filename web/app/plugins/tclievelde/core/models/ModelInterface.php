<?php

namespace Tclievelde\core\models;

use Tclievelde\core\Actionable;

/**
 * Interface ModelInterface
 * @package posts
 */
interface ModelInterface extends
    Actionable,
    CustomPostTypeInstantiatorInterface,
    AcfFieldsInterface
{
}
