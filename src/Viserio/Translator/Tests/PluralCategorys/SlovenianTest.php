<?php
namespace Viserio\Translator\Tests\PluralCategorys;

use Viserio\Translator\PluralCategorys\Slovenian;

class SlovenianTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new Slovenian();
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
            [101, 'one'],
            [201, 'one'],
            [301, 'one'],
            [401, 'one'],
            [501, 'one'],
            [2, 'two'],
            ['2', 'two'],
            [2.0, 'two'],
            ['2.0', 'two'],
            [102, 'two'],
            [202, 'two'],
            [302, 'two'],
            [402, 'two'],
            [502, 'two'],
            [3, 'few'],
            [4, 'few'],
            ['4', 'few'],
            [4.0, 'few'],
            ['4.0', 'few'],
            [103, 'few'],
            [104, 'few'],
            [203, 'few'],
            [204, 'few'],
            [0, 'other'],
            [5, 'other'],
            [6, 'other'],
            [8, 'other'],
            [10, 'other'],
            [11, 'other'],
            [29, 'other'],
            [60, 'other'],
            [99, 'other'],
            [100, 'other'],
            [105, 'other'],
            [189, 'other'],
            [200, 'other'],
            [205, 'other'],
            [300, 'other'],
            [1.31, 'other'],
            [2.31, 'other'],
            [3.31, 'other'],
            [5.31, 'other'],
        ];
    }
}
