<?php
namespace Viserio\StaticalProxy\Tests\Fixture;

use StdClass;
use Viserio\StaticalProxy\StaticalProxy;

class FacadeObjectStub extends StaticalProxy
{
    public static function getInstanceIdentifier()
    {
        return new StdClass();
    }
}
