<?php
namespace App;

use App\Exceptions\AntOutOfBoundsException;
use App\Exceptions\InvalidAttributeException;

class World
{
    /**
     * @var Ant
     */
    protected $ant;

    /**
     * @var CoordinateLimit
     */
    protected $limit;

    /**
     * @var array
     */
    protected $coordinates = [];


    public function __construct(CoordinateLimit $limit, Ant $ant)
    {
        $this->limit = $limit;
        if ( $this->limit->validateCoordinate( $ant->getCoordinate() ) ) {
            $this->ant = $ant;
        } else {
            throw new AntOutOfBoundsException('Ant must be placed within the world limits');
        }

        $this->addAntCoordinate();
    }

    /**
     * @return CoordinateLimit
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return Ant
     */
    public function ant()
    {
        return $this->ant;
    }


    public function tick()
    {
        $current = $this->ant->getCoordinate();
        $currentState = $this->coordinateState($current);

        // Only walk if the new coordinate is within the world limits
        if ($this->limit->validateCoordinate($this->ant->query($currentState))) {
            $this->ant->walk($currentState);
            $this->toggleCoordinate($current);
            $this->addAntCoordinate();
        } else {
            return false;
        }
    }

    /**
     * @return array
     */
    public function coordinates()
    {
        return $this->coordinates;
    }

    private function addAntCoordinate()
    {
        $coordinate = $this->ant->getCoordinate();
        $value = false;
        if ($this->coordinateState($coordinate) !== null) {
            $value = $this->coordinateState($coordinate);
        }
        $this->coordinates[$this->formatCoordinate($coordinate)] = $value;
    }

    private function toggleCoordinate(array $coordinate)
    {
        $key = $this->formatCoordinate($coordinate);
        $this->coordinates[$key] = ! $this->coordinates[$key];
    }

    private function coordinateState(array $coordinate)
    {
        return $this->coordinates[$this->formatCoordinate($coordinate)];
    }

    private function formatCoordinate($coordinate)
    {
        if (is_array($coordinate) && count($coordinate) == 2) {
            return implode(',', $coordinate);
        } elseif (is_string($coordinate)) {
            return explode(',', $coordinate);
        } else {
            throw new InvalidAttributeException('Coordinate must be either a string or array');
        }

    }

}