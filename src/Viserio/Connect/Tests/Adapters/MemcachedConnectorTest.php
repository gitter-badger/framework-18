<?php
namespace Viserio\Connect\Tests\Adapters;

use Memcached;
use Narrowspark\TestingHelper\Traits\MockeryTrait;
use Viserio\Connect\Adapters\MemcachedConnector;

class MemcachedConnectorTest extends \PHPUnit_Framework_TestCase
{
    use MockeryTrait;

    public function setUp()
    {
        $this->allowMockingNonExistentMethods(true);
    }

    public function testConnect()
    {
        $config = [
            'servers' => [
                [
                    'host' => 'localhost',
                    'port' => 11211,
                    'weight' => 100,
                ],
            ],
        ];

        $memcached = $this->mock('stdClass');
        $memcached->shouldReceive('addServer')->once()->with('localhost', 11211, 100);
        $memcached->shouldReceive('getServerList')->once()->andReturn(null);
        $memcached->shouldReceive('getVersion')->once()->andReturn([]);

        $connector = $this->getMockBuilder('Viserio\Connect\Adapters\MemcachedConnector')
            ->setMethods(['getMemcached'])
            ->getMock();
        $connector->expects($this->once())->method('getMemcached')->will($this->returnValue($memcached));

        $this->assertSame($connector->connect($config), $memcached);
    }

    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage Could not establish Memcached connection.
     */
    public function testExceptionThrownOnBadConnection()
    {
        $config = [
            'servers' => [
                [
                    'host' => 'localhost',
                    'port' => 11211,
                    'weight' => 100,
                ],
            ],
        ];

        $memcached = $this->mock('stdClass');
        $memcached->shouldReceive('addServer')->once()->with('localhost', 11211, 100);
        $memcached->shouldReceive('getServerList')->once()->andReturn(null);
        $memcached->shouldReceive('getVersion')->once()->andReturn(['255.255.255']);

        $connector = $this->getMockBuilder('Viserio\Connect\Adapters\MemcachedConnector')
            ->setMethods(['getMemcached'])
            ->getMock();
        $connector->expects($this->once())->method('getMemcached')->will($this->returnValue($memcached));

        $connector->connect($config);
    }

    public function testAddMemcachedOptions()
    {
        if (! extension_loaded('memcached')) {
            $this->markTestSkipped('Memcached is not loaded.');
        }

        $config = [
                'options' => [
                    'OPT_NO_BLOCK'         => true,
                    'OPT_CONNECT_TIMEOUT'  => 2000,
                    'OPT_POLL_TIMEOUT'     => 2000,
                    'OPT_RETRY_TIMEOUT'    => 2,
                ],
                'servers' => [
                    [
                        'host' => 'localhost',
                        'port' => 11211,
                        'weight' => 100,
                    ],
                ],
            ];

        if (! defined('HHVM_VERSION')) {
            $config = array_merge($config, [
                'options' => [
                    'OPT_AUTO_EJECT_HOSTS' => true,
                ],
            ]);
        }

        $connector = (new MemcachedConnector())->connect($config);

        if (! defined('HHVM_VERSION')) {
            $this->assertSame(1, $connector->getOption(Memcached::OPT_AUTO_EJECT_HOSTS));
        }

        $this->assertSame(1, $connector->getOption(Memcached::OPT_NO_BLOCK));
        $this->assertSame(2000, $connector->getOption(Memcached::OPT_CONNECT_TIMEOUT));
        $this->assertSame(2000, $connector->getOption(Memcached::OPT_POLL_TIMEOUT));
        $this->assertSame(2, $connector->getOption(Memcached::OPT_RETRY_TIMEOUT));
    }

    /**
     * Need memcached with sasl support.
     */
    public function testAddSaslAuth()
    {
        if (! extension_loaded('memcached')) {
            $this->markTestSkipped('Memcached is not loaded.');
        }

        if (getenv('TRAVIS')) {
            $this->markTestSkipped('Memcached dont support sasl on travis.');
        }

        $config = [
            'sasl' => [
                'username' => 'test',
                'password' => 'testpassword',
            ],
            'servers' => [
                [
                    'host' => 'localhost',
                    'port' => 11211,
                    'weight' => 100,
                ],
            ],
        ];

        $connector = (new MemcachedConnector())->connect($config);

        $this->assertSame(1, $connector->getOption(Memcached::OPT_BINARY_PROTOCOL));
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage No Memcached servers added.
     */
    public function testNoMemcachedServerAdded()
    {
        $config = [];

        $memcached = $this->mock('stdClass');
        $memcached->shouldReceive('getVersion')->once()->andReturn('');
        $memcached->shouldReceive('getServerList')->once()->andReturn($config);

        $connector = $this->getMockBuilder('Viserio\Connect\Adapters\MemcachedConnector')
            ->setMethods(['getMemcached'])
            ->getMock();
        $connector->expects($this->once())->method('getMemcached')->will($this->returnValue($memcached));

        $connector->connect($config);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Invalid Memcached option: [Memcached::OPT_NO_FAIL]
     */
    public function testAddBadMemcachedOptionsToThrowExeption()
    {
        if (! extension_loaded('memcached')) {
            $this->markTestSkipped('Memcached is not loaded.');
        }

        $config = [
            'options' => [
                'OPT_NO_FAIL' => true,
            ],
        ];

        (new MemcachedConnector())->connect($config);
    }
}
