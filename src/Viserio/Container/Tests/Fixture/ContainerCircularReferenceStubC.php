<?php
namespace Viserio\Container\Tests\Fixture;

class ContainerCircularReferenceStubC
{
    public function __construct(ContainerCircularReferenceStubB $b)
    {
    }
}