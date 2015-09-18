<?php
namespace App;

class Simulation
{
    /**
     * @var World
     */
    protected $world;

    /**
     * @param World $world
     */
    public function __construct(World $world)
    {
        $this->world = $world;
    }

    /**
     * @return World
     */
    public function getWorld()
    {
        return $this->world;
    }

    public function run($count = 1)
    {
        for ($i = 0; $i < $count; $i++) {
            $this->world->tick();
        }
        return $this->world->coordinates();
    }
}