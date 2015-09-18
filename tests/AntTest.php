<?php

use App\Ant;

class AntTest extends PHPUnit_Framework_TestCase
{
    public function test_instantiated_properly()
    {
        $ant = new Ant([ 42, 42 ]);
        $this->assertInstanceOf(Ant::class, $ant);
        $this->assertEquals([ 42, 42 ], $ant->getCoordinate());
    }

    public function test_ants_can_be_created_with_an_initial_direction()
    {
        $direction = 3;
        $ant = new Ant([ 42, 42 ], $direction);
        $this->assertEquals($direction, $ant->getDirection());
    }

    public function test_ant_tells_you_where_it_wants_to_move_to_but_does_not_change()
    {
        $ant = new Ant([ 42, 42 ], 1);
        $this->assertEquals( [ 41, 42 ], $ant->query(false));
        $this->assertEquals( [42, 42], $ant->getCoordinate());
        $this->assertEquals( 1 , $ant->getDirection());
    }

    public function test_the_ant_moves_to_a_new_coordinate()
    {
        $ant = new Ant([ 42, 42 ], 1);
        $new = [ 41, 42 ];
        $this->assertEquals( $new, $ant->walk(false));
        $this->assertEquals( $new, $ant->getCoordinate());
        $this->assertEquals( 4 , $ant->getDirection());
    }
}