<?php
namespace Viserio\Translator\Tests\PluralCategorys;

use Viserio\Translator\PluralCategorys\Macedonian;

class MacedonianTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new Macedonian();
    }

    /**
     * @dataProvider category
     */
    public function testGetCategory($count, $expected)
    {
        $actual = $this->object->category($count);
        $this->assertEquals($expected, $actual);
    }

    public function category()
    {
        return [
            [1, 'one'],
            ['1', 'one'],
            [1.0, 'one'],
            ['1.0', 'one'],
            [21, 'one'],
            [31, 'one'],
            [41, 'one'],
            [51, 'one'],
            [101, 'one'],
            [0, 'other'],
            [2, 'other'],
            [3, 'other'],
            [5, 'other'],
            [9, 'other'],
            [11, 'other'],
            [13, 'other'],
            [14, 'other'],
            [18, 'other'],
            [19, 'other'],
            [20, 'other'],
            [22, 'other'],
            [25, 'other'],
            [30, 'other'],
            [32, 'other'],
            [40, 'other'],
            [0.31, 'other'],
            [1.31, 'other'],
            [1.99, 'other'],
        ];
    }
}
