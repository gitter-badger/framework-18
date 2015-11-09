<?php
namespace Viserio\Container\Exception;

/**
 * Narrowspark - a PHP 5 framework.
 *
 * @author      Daniel Bannert <info@anolilab.de>
 * @copyright   2015 Daniel Bannert
 *
 * @link        http://www.narrowspark.de
 *
 * @license     http://www.narrowspark.com/license
 *
 * @version     0.10.0-dev
 */

use Interop\Container\Exception\ContainerException as InteropContainerException;

/**
 * ContainerException.
 *
 * @author  Daniel Bannert
 *
 * @since   0.9.4-dev
 */
class ContainerException extends \Exception implements InteropContainerException
{
}