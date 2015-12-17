<?php
namespace Viserio\Cookie\Test;

use Mockery as Mock;
use Symfony\Component\HttpFoundation\Request;
use Viserio\Cookie\CookieJar;

class CookieJarTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        Mock::close();
    }

    public function testCookiesAreCreatedWithProperOptions()
    {
        $cookie = $this->getCreator();
        $cookie->setDefaultPathAndDomain('foo', 'bar');

        $c = $cookie->make('color', 'blue', 10, '/path', '/domain', true, false);
        $this->assertEquals('blue', $c->getValue());
        $this->assertFalse($c->isHttpOnly());
        $this->assertTrue($c->isSecure());
        $this->assertEquals('/domain', $c->getDomain());
        $this->assertEquals('/path', $c->getPath());

        $c2 = $cookie->forever('color', 'blue', '/path', '/domain', true, false);
        $this->assertEquals('blue', $c2->getValue());
        $this->assertFalse($c2->isHttpOnly());
        $this->assertTrue($c2->isSecure());
        $this->assertEquals('/domain', $c2->getDomain());
        $this->assertEquals('/path', $c2->getPath());

        $c3 = $cookie->forget('color');
        $this->assertNull($c3->getValue());
        $this->assertTrue($c3->getExpiresTime()->getTimestamp() < time());
    }

    public function testCookiesAreCreatedWithProperOptionsUsingDefaultPathAndDomain()
    {
        $cookie = $this->getCreator();
        $cookie->setDefaultPathAndDomain('/path', '/domain');

        $c = $cookie->make('color', 'blue', 10, null, null, true, false);
        $this->assertEquals('blue', $c->getValue());
        $this->assertFalse($c->isHttpOnly());
        $this->assertTrue($c->isSecure());
        $this->assertEquals('/domain', $c->getDomain());
        $this->assertEquals('/path', $c->getPath());
    }

    public function getCreator()
    {
        return new CookieJar(Request::create('/foo', 'GET'), [
            'path' => '/path',
            'domain' => '/domain',
            'secure' => true,
            'httpOnly' => false,
        ]);
    }
}
