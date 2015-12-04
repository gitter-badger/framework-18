<?php
namespace Viserio\Translator\Tests\PluralCategorys;

use Viserio\Translator\PluralCategorys\Welsh;

class WelshTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new Welsh();
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
            [0, 'zero'],
            ['0', 'zero'],
            [0.0, 'zero'],
            ['0.0', 'zero'],
            [1, 'one'],
            ['1', 'one'],
            [1.0, 'one'],
            ['1.0', 'one'],
            [2, 'two'],
            ['2', 'two'],
            [2.0, 'two'],
            ['2.0', 'two'],
            [3, 'few'],
            ['3', 'few'],
            [3.0, 'few'],
            ['3.0', 'few'],
            [6, 'many'],
            ['6', 'many'],
            [6.0, 'many'],
            ['6.0', 'many'],
            [4, 'other'],
            [5, 'other'],
            [7, 'other'],
            [8, 'other'],
            [10, 'other'],
            [12, 'other'],
            [14, 'other'],
            [19, 'other'],
            [69, 'other'],
            [198, 'other'],
            [384, 'other'],
            [999, 'other'],
            [1.31, 'other'],
            [2.31, 'other'],
            [8.31, 'other'],
            [11.31, 'other'],
        ];
    }
}
