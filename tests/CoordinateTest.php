<?php

use App\Coordinate;
use App\CoordinateLimit;

class CoordinateTest extends \PHPUnit_Framework_TestCase
{
    public function testCoordinateInstantiated()
    {
        $coordinate = $this->getSimpleCoordinate();

        $this->assertInstanceOf('App\Coordinate', $coordinate);
        $this->assertEquals($this->x, $coordinate->getX());
        $this->assertEquals($this->y, $coordinate->getY());
    }

    public function testCoordinatesAsArray()
    {
        $coordinate = $this->getSimpleCoordinate();
        $this->assertEquals([$this->x, $this->y], $coordinate->get());
    }

    /**
     * @expectedException App\Exceptions\InvalidAttributeException
     */
    public function testCoordinateCanOnlyBeCreatedWithIntegers()
    {
        $coordinate = new Coordinate(42, 'not an integer');
    }

    public function test_it_checks_if_two_coordinates_are_equal()
    {
        $one = new Coordinate(15, 20);
        $two = new Coordinate(15, 20);
        $three = new Coordinate(10, 30);

        $this->assertTrue($one->equals($two));
        $this->assertTrue($two->equals($one));
        $this->assertFalse($one->equals($three));
    }

    public function test_it_can_check_if_coordinate_equals_array_values()
    {
        $coordinate = new Coordinate( 10, 10 );
        $this->assertTrue($coordinate->equals([ 10, 10 ]));
        $this->assertTrue($coordinate->equals([ "x" => 10, "y" => 10 ]));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_you_cannot_check_if_coordinate_is_equal_with_correct_arguments()
    {
        $coordinate = new Coordinate( 10, 10 );
        $coordinate->equals('one,two');
    }

    public function test_the_coordinate_can_be_turned_on_or_off()
    {
        $coordinate = new Coordinate(42,42);
        $this->assertFalse($coordinate->active()); // Check default value is false
        $coordinate->toggle();
        $this->assertTrue($coordinate->active());
    }

    public function test_toggling_a_coordinate_returns_the_new_value()
    {
        $coordinate = new Coordinate(42,42);
        $this->assertTrue($coordinate->toggle());
    }

    private $x = 42;
    private $y = 99;

    private function getSimpleCoordinate()
    {
        return new Coordinate($this->x, $this->y);
    }
}