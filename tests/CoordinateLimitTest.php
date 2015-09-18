<?php

use App\Coordinate;
use App\CoordinateLimit;

class CoordinateLimitTest extends PHPUnit_Framework_TestCase
{
    public function test_limit_created_properly()
    {
        $limitX = 100;
        $limitY = 100;
        $limits = [
            "x" => [-100, 100],
            "y" => [-100, 100]
        ];
        $limit = new CoordinateLimit( $limitX, $limitY );
        $this->assertEquals($limits, $limit->getLimits());
    }

    /**
     * @expectedException App\Exceptions\InvalidLimitValueException
     */
    public function test_it_throws_exception_if_created_with_zero()
    {
        $limit = new CoordinateLimit( 0, 0 );
    }

    /**
     * @expectedException App\Exceptions\InvalidAttributeException
     */
    public function test_it_throws_exception_if_created_with_non_integers()
    {
        $limit = new CoordinateLimit('string', 2);
    }

    public function test_it_checks_coordinates_are_within_limits()
    {
        $limit = new CoordinateLimit( 100, 100 );
        $this->assertTrue($limit->validateCoordinate( [20, 50] ));
    }

    public function test_faulty_coordinate_returns_false_when_validated()
    {
        $limit = new CoordinateLimit( 100, 100 );
        $this->assertFalse($limit->validateCoordinate( [1000, 1000] ));
    }

    public function test_it_returns_the_min_and_max_x_values()
    {
        $limit = new CoordinateLimit( 100, 100 );
        $this->assertEquals([-100, 100], $limit->xLimits());
    }

    public function test_it_returns_the_min_and_max_y_values()
    {
        $limit = new CoordinateLimit( 100, 100 );
        $this->assertEquals([-100, 100], $limit->yLimits());
    }
}