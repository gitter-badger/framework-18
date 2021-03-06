<?php
namespace Viserio\Routing\Test;

use FastRoute\DataGenerator\GroupCountBased;
use Viserio\Container\Container;
use Viserio\Routing\RouteCollection;
use Viserio\Routing\RouteParser;

class DispatcherTest extends \PHPUnit_Framework_TestCase
{
    private function getRouteCollection()
    {
        return new RouteCollection(
            new Container(),
            new RouteParser(),
            new GroupCountBased()
        );
    }
}
