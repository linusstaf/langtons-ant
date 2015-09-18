<?php

use App\Ant;
use App\CoordinateLimit;
use App\Simulation;
use App\World;

class SimulationTest extends PHPUnit_Framework_TestCase
{
    public function test_it_instantiates_correctly()
    {
        $simulation = $this->simulation();
        $this->assertInstanceOf(Simulation::class, $simulation);
        $this->assertInstanceOf(World::class, $simulation->getWorld());
    }

    public function test_simulation_can_run()
    {
        $simulation = $this->simulation();
        $this->assertCount(2, $simulation->run());
    }

    public function test_simulation_can_run_multiple_times()
    {
        $simulation = $this->simulation();
        $this->assertCount(4, $simulation->run(3));
    }
    private function simulation()
    {
        return new Simulation(
            new World(
                new CoordinateLimit( 10, 10 ),
                new Ant()
            )
        );
    }
}