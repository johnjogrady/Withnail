<?php
/**
 * Class Category | core/SimpleParser.php
 *
 * @version     v.1.0 (06/01/2016)
 * @Author John O'Grady
 *
 */
namespace Itb;

class SimpleParser
{
    /**
     * Test Utility class
     */
    public function parseAndSum($numbers)
    {
        $isEmptyString = (strlen($numbers) === 0);

        if ($isEmptyString) {
            return 0;
        }

        $containsCommas = strrchr($numbers, ',');

        if (!$containsCommas) {
            return intval($numbers);
        } else {
            throw new \Exception('I can only handle 0 or 1 numbers for now!');
        }
    }
}
