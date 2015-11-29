<?php
namespace Viserio\Application\Tests;

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
 * @version     0.10.0
 */

use Viserio\Application\Application;

/**
 * ApplicationTest.
 *
 * @author  Daniel Bannert
 *
 * @since   0.9.5
 */
class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    public function testGetProviderByParentClass()
    {
        $app = new Application(['test', 'test2']);
        $app->register('ApplicationChildProviderStub');
        $this->assertEquals($app->getProvider('ApplicationChildProviderStub'), $app->getProvider('ApplicationParentProviderStub'));
        $this->assertEquals($app->getProvider('ApplicationChildProviderStub'), $app->getProvider('ApplicationInterfaceProviderStub'));
    }
}

class ApplicationParentProviderStub extends \Viserio\Application\ServiceProvider
{
    public function register()
    {
    }
}

interface ApplicationInterfaceProviderStub
{
}

class ApplicationChildProviderStub extends ApplicationParentProviderStub implements ApplicationInterfaceProviderStub
{
    public function register()
    {
    }
}
