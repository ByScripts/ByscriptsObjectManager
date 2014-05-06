<?php
/*
 * This file is part of the ByscriptsObjectManager package.
 *
 * (c) Thierry Goettelmann <thierry@byscripts.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Byscripts\Test\ObjectManager\Fixtures;

use Byscripts\ObjectManager\Exception\ObjectManagerException;
use Byscripts\ObjectManager\Manager\AbstractObjectManager;

/**
 * Class ProductManager
 *
 * @author Thierry Goettelmann <thierry@byscripts.info>
 */
class ProductManager extends AbstractObjectManager
{
    public function processBasic()
    {
        echo "Processing";
    }

    public function processBasicWithArgument($argument)
    {
        echo "Processing " . $argument;
    }

    public function processBasicWithArguments($argument1, $argument2, $argument3)
    {
        printf("Processing %s, %s and %s", $argument1, $argument2, $argument3);
    }

    public function processGoodWine()
    {
        // All is fine
    }

    public function onGoodWineSuccess()
    {
        echo 'Good wine is good';
    }

    public function processBadWine()
    {
        throw new ObjectManagerException();
    }

    public function onBadWineError()
    {
        echo 'Bad wine is bad';
    }

    public function processGoodBeer()
    {
        return "I like beer";
    }

    public function onGoodBeerSuccess($data, $processResult)
    {
        echo $processResult;
    }

    public function processWarmBeer()
    {
        throw new ObjectManagerException('This beer is warm');
    }

    public function onWarmBeerError($data, $errorMessage)
    {
        echo $errorMessage;
    }

    public function processException()
    {
        throw new \Exception('Uh oh!');
    }

    public function processOperatingSystem($first, $second, $third)
    {
        return sprintf('%s, %s and %s are bad! I prefer AmigaOS!', $first, $second, $third);
    }

    public function onOperatingSystemSuccess($first, $second, $third, $processResult)
    {
        printf('Do you work on %s, %s or %s? %s', $first, $second, $third, $processResult);
    }

    public function processWhatTimeIsIt($hour, $minute)
    {
        throw new ObjectManagerException('I\'m late!!');
    }

    public function onWhatTimeIsItError($hour, $minute, $errorMessage)
    {
        printf('It is... %d:%d?! %s', $hour, $minute, $errorMessage);
    }
}
