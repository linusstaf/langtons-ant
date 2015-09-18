<?php
namespace App;

class Ant
{

    /**
     * The X-coordinate of the ant
     * @var
     */
    protected $x;

    /**
     * The Y-coordinate of the ant
     * @var int
     */
    protected $y;

    /**
     * The direction the ant is facing in
     *
     *      1 = up
     *      2 = right
     *      3 = down
     *      4 = left
     *
     * @var int
     */
    protected $direction;

    /**
     * @param array $coordinate
     * @param int $direction
     */
    public function __construct(array $coordinate = [0, 0], $direction = 1)
    {
        $this->setCoordinate($coordinate);
        $this->direction = $direction;
    }

    /**
     * @param array $coordinate
     * @return array
     */
    private function setCoordinate(array $coordinate)
    {
        $this->x = $coordinate[0];
        $this->y = $coordinate[1];

        return [$this->x, $this->y];
    }

    /**
     * @return array
     */
    public function getCoordinate()
    {
        return [ $this->x, $this->y ];
    }

    /**
     * @return int
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * @param bool $coordinateState
     * @return mixed
     */
    public function query($coordinateState)
    {
        return $this->nextCoordinate(
            $this->turn($coordinateState)
        );

    }

    /**
     * @param bool $coordinateState
     * @return array
     */
    public function walk($coordinateState)
    {
        $this->direction = $this->turn($coordinateState);

        return $this->setCoordinate(
            $this->nextCoordinate(
                $this->direction
            )
        );
    }

    /**
     * @param int $direction
     * @return array
     */
    private function nextCoordinate($direction)
    {
        $x = $this->x;
        $y = $this->y;

        if ($direction == 1) $y++;      // Move up
        elseif ($direction == 2) $x++;  // Move right
        elseif ($direction == 3) $y--;  // Move down
        elseif ($direction == 4) $x--;  // Move left
        return [ $x, $y ];
    }


    /**
     * @return int
     */
    private function turnLeft()
    {
        if ($this->direction == 1) {
            return 4;
        } else {
            return $this->direction - 1;
        }
    }

    /**
     * @return int
     */
    private function turnRight()
    {
        if ($this->direction == 4) {
            return 1;
        } else {
            return $this->direction + 1;
        }
    }

    /**
     * @param bool $coordinateState
     * @return int
     */
    private function turn($coordinateState)
    {
        if ($coordinateState) {
            return $this->turnRight();
        } else {
            return $this->turnLeft();
        }
    }



}