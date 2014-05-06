<?php
/*
 * This file is part of the ByscriptsObjectManager package.
 *
 * (c) Thierry Goettelmann <thierry@byscripts.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use Byscripts\Test\ObjectManager\Fixtures\ProductManager;

/**
 * Class ObjectManagerTest
 *
 * @author Thierry Goettelmann <thierry@byscripts.info>
 */
class ObjectManagerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ProductManager
     */
    private $manager;

    protected function setUp()
    {
        $this->manager = new ProductManager();
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Method not found: processNotExists
     */
    public function testNoProcessMethod()
    {
        $this->manager->execute('notExists', null);
    }

    public function testBasic()
    {
        $this->expectOutputString('Processing');
        $this->manager->execute('basic', null);
    }

    public function testBasicWithArgument()
    {
        $this->expectOutputString('Processing foobar');
        $this->manager->execute('basicWithArgument', 'foobar');
    }

    public function testBasicWithArguments()
    {
        $this->expectOutputString('Processing foo, bar and baz');
        $this->manager->execute('basicWithArguments', 'foo', 'bar', 'baz');
    }

    public function testSuccess()
    {
        $this->expectOutputString('Good wine is good');
        $this->manager->execute('goodWine', null);
    }

    public function testError()
    {
        $this->expectOutputString('Bad wine is bad');
        $this->manager->execute('badWine', null);
    }

    public function testSuccessWithProcessResult()
    {
        $this->expectOutputString('I like beer');
        $this->manager->execute('goodBeer', null);
    }

    public function testErrorWithCustomMessage()
    {
        $this->expectOutputString('This beer is warm');
        $this->manager->execute('warmBeer', null);
    }

    public function testUncaughtException()
    {
        $this->setExpectedException('Exception', 'Uh oh!');
        $this->manager->execute('exception', null);
    }

    public function testSuccessWithArguments()
    {
        $this->expectOutputString('Do you work on Linux, Windows or MacOSX? Linux, Windows and MacOSX are bad! I prefer AmigaOS!');
        $this->manager->execute('operatingSystem', 'Linux', 'Windows', 'MacOSX');
    }

    public function testErrorWithArguments()
    {
        $this->expectOutputString('It is... 9:30?! I\'m late!!');
        $this->manager->execute('whatTimeIsIt', 9, 30);
    }

    public function testLotOfArguments()
    {
        $this->expectOutputString("115200");
        $this->manager->execute('lotOfArgs', 2, 4, 6, 8, 10);
    }
}
