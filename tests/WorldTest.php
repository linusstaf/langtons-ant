<?php

use App\Ant;
use App\CoordinateLimit;
use App\World;

class WorldTest extends PHPUnit_Framework_TestCase
{

    public function test_world_instantiates_correctly()
    {
        $world = new World(
            new CoordinateLimit( 100, 100 ),
            new Ant()
        );
        $this->assertInstanceOf(World::class, $world);
        $this->assertInstanceOf(CoordinateLimit::class, $world->getLimit());
        $this->assertInstanceOf(Ant::class, $world->ant());
    }

    /**
     * @expectedException App\Exceptions\AntOutOfBoundsException
     */
    public function test_ant_must_be_located_within_limits()
    {
        $world = new World(
            new CoordinateLimit( 100, 100 ),
            new Ant([120, 0])
        );
    }

    public function test_world_moves_ants_and_toggles_coordinate_states()
    {
        $world = $this->createBasicWorld();
        $coordinate = [-1, 0];
        $world->tick();
        $this->assertEquals( $coordinate, $world->ant()->getCoordinate() );
        $this->assertEquals(2, array_sum(array_map("count", $world->coordinates())));
    }

    public function test_fourth_iteration_returns_to_the_first_coordinate()
    {
        $world = $this->createBasicWorld();
        foreach(range(1,4) as $i) {
            $world->tick();
        }
        $this->assertEquals(4, array_sum(array_map("count", $world->coordinates())));
        $this->assertEquals( [0, 0], $world->ant()->getCoordinate());
    }

    public function test_fifth_iteration_makes_ant_face_right()
    {
        $world = $this->createBasicWorld();
        foreach(range(1,5) as $i) {
            $world->tick();
        }
        $this->assertEquals(5, array_sum(array_map("count", $world->coordinates())));
        $this->assertEquals( [1, 0], $world->ant()->getCoordinate() );
        $this->assertEquals( 2, $world->ant()->getDirection() );
    }

    public function test_world_stops_ticking_when_ant_reaches_world_limit()
    {
        $world = new World(
            new CoordinateLimit( 1, 1 ),
            new Ant( [1, 1] )
        );
        foreach(range(1,4) as $i) {
            $world->tick();
        }
        $this->assertFalse($world->tick());
    }

    private function createBasicWorld()
    {
        $limit = new CoordinateLimit( 100, 100 );
        $ant = new Ant( [0, 0] );
        return new World($limit, $ant);
    }
}