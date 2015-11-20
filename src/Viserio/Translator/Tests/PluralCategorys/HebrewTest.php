<?php
namespace Viserio\Translator\Tests\PluralCategorys;

/*
 * Narrowspark - a PHP 5 framework
 *
 * @author      Daniel Bannert <info@anolilab.de>
 * @copyright   2015 Daniel Bannert
 * @link        http://www.narrowspark.de
 * @license     http://www.narrowspark.com/license
 * @version     0.9.6-dev
 * @package     Narrowspark/framework
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

use Viserio\Translator\PluralCategorys\Hebrew;

/**
 * HebrewTest.
 *
 * @author  Daniel Bannert
 *
 * @since   0.9.6-dev
 */
class HebrewTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new Hebrew();
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
            [2, 'two'],
            ['2', 'two'],
            [2.0, 'two'],
            ['2.0', 'two'],
            [10, 'many'],
            ['10', 'many'],
            [10.0, 'many'],
            ['10.0', 'many'],
            [20, 'many'],
            [100, 'many'],
            [0, 'other'],
            [3, 'other'],
            [9, 'other'],
            [77, 'other'],
            [301, 'other'],
            [999, 'other'],
            [1.31, 'other'],
            [5.45, 'other'],
        ];
    }
}
