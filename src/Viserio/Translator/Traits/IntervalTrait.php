<?php
namespace Viserio\Translator\Traits;

use InvalidArgumentException;

trait IntervalTrait
{
    use NormalizeIntegerValueTrait;

    /**
     * Tests if the given number is in the math interval.
     *
     * @param int    $number
     * @param string $interval
     *
     * @throws \InvalidArgumentException
     *
     * @return bool
     */
    public function intervalTest($number, $interval)
    {
        $interval = trim($interval);
        $number   = $this->normalizeInteger($number);

        if (!preg_match('/^' . $this->getIntervalRegexp() . '$/x', $interval, $matches)) {
            throw new InvalidArgumentException(sprintf('"%s" is not a valid interval.', $interval));
        }

        if ($matches[1]) {
            foreach (explode(',', $matches[2]) as $matchedNumber) {
                if ($number === $this->normalizeInteger($matchedNumber)) {
                    return true;
                }
            }
        } else {
            $leftNumber  = $this->convertNumber($matches['left']);
            $rightNumber = $this->convertNumber($matches['right']);

            return
                ('[' === $matches['left_delimiter'] ? $number >= $leftNumber : $number > $leftNumber) &&
                (']' === $matches['right_delimiter'] ? $number <= $rightNumber : $number < $rightNumber)
            ;
        }

        return false;
    }

    /**
     * Returns a Regexp that matches valid intervals.
     *
     * @return string A Regexp (without the delimiters)
     */
    public function getIntervalRegexp()
    {
        return <<<EOF
        ({\s*
            (\-?\d+(\.\d+)?[\s*,\s*\-?\d+(\.\d+)?]*)
        \s*})

            |

        (?P<left_delimiter>[\[\]])
            \s*
            (?P<left>-Inf|\-?\d+(\.\d+)?)
            \s*,\s*
            (?P<right>\+?Inf|\-?\d+(\.\d+)?)
            \s*
        (?P<right_delimiter>[\[\]])
EOF;
    }

    /**
     * Convert number.
     *
     * @param int $number
     *
     * @return float
     */
    protected function convertNumber($number)
    {
        if ('-Inf' === $number) {
            return log(0);
        } elseif ('+Inf' === $number || 'Inf' === $number) {
            return -log(0);
        }

        return (float) $number;
    }
}
