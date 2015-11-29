<?php
namespace Viserio\Config\Test;

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

use Viserio\Config\Manager as ConfigManager;
use Viserio\Config\Repository;

/**
 * ConfigManagerTest.
 *
 * @author  Daniel Bannert
 *
 * @since   0.9.6
 */
class ConfigManagerTest extends \PHPUnit_Framework_TestCase
{
    public $defaults = [
        'cookies.encrypt' => false,
        'cookies.lifetime' => '20 minutes',
        'cookies.path' => '/',
        'cookies.domain' => null,
        'cookies.secure' => false,
        'cookies.httponly' => false,
    ];

    public function testConstructorInjection()
    {
        $values = ['param' => 'value'];
        $config = $this->getConfig();

        $config->setArray($values);

        $this->assertSame($values['param'], $con['param']);
    }

    public function testSetDefaultValues()
    {
        $config = $this->getConfig();

        foreach ($this->defaults as $key => $value) {
            $this->assertEquals($con[$key], $value);
        }
    }

    public function testGetDefaultValues()
    {
        $config   = $this->getConfig();
        $defaults = $config->getDefaults();

        foreach ($this->defaults as $key => $value) {
            $this->assertEquals($defaults[$key], $value);
        }
    }

    public function testCallHandlerMethod()
    {
        $config = $this->getConfig();

        $defaultKeys = array_keys($this->defaults);
        $defaultKeys = ksort($defaultKeys);
        $configKeys  = $config->callHandlerMethod('getKeys');
        $configKeys  = ksort($configKeys);
        $this->assertEquals($defaultKeys, $configKeys);
    }

    protected function getConfig()
    {
        return new ConfigManager(new Repository());
    }
}
