<?php
namespace App;

use App\Exceptions\InvalidAttributeException;

class Coordinate
{
    /**
     * @var bool
     */
    protected $active = false;

    /**
     * @var int
     */
    private $x;

    /**
     * @var int
     */
    private $y;

    /**
     * @param $x int
     * @param $y int
     * @throws InvalidAttributeException
     */
    public function __construct($x, $y)
    {
        if (!is_int($x) || !is_int($y)) {
            throw new InvalidAttributeException(
                'Invalid attribute given. Coordinates can only be created with integers.'
            );
        }
        $this->x = $x;
        $this->y = $y;

    }

    /**
     * Generate a random coordinate within the given limits
     *
     * @param CoordinateLimit $limits
     * @return Coordinate
     */
    public static function random(CoordinateLimit $limits)
    {
        return new self(
            rand($limits->xLimits()["min"], $limits->xLimits()["max"]),
            rand($limits->yLimits()["min"], $limits->yLimits()["max"])
        );
    }

    /**
     * Returns the Y coordinate
     *
     * @return int
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * Returns the X-coordinate
     *
     * @return int
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * Returns the coordinates as an array
     *
     * @return array
     */
    public function get()
    {
        return [$this->x, $this->y];
    }

    /**
     * Checks if another coordinate occupies the same space
     *
     * @param array|Coordinate $test
     * @return bool
     */
    public function equals($test)
    {
        if ($test instanceof Coordinate) {
            return (
                $this->x == $test->getX() &&
                $this->y == $test->getY()
            );
        } elseif (is_array($test)) {
            if (array_key_exists("x", $test)) {
                return (
                    $this->x == $test["x"] &&
                    $this->y == $test["y"]
                );
            } else {
                return (
                    $this->x == $test[0] &&
                    $this->y == $test[1]
                );
            }
        } else {
            throw new \InvalidArgumentException(
                'Invalid argument passed to function. Please pass either a coordinate or an array with x and y values.'
            );
        }
    }

    /**
     * @return bool
     */
    public function active()
    {
        return $this->active;
    }

    /**
     * @return bool
     */
    public function toggle()
    {
        return $this->active = ! $this->active;
    }
}