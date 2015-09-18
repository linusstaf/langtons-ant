<?php
namespace App;

use App\Exceptions\InvalidAttributeException;
use App\Exceptions\InvalidLimitValueException;

class CoordinateLimit
{
    /**
     * @var int
     */
    protected $xMin;

    /**
     * @var int
     */
    protected $xMax;

    /**
     * @var int
     */
    protected $yMin;

    /**
     * @var int
     */
    protected $yMax;

    /**
     * @param int $x
     * @param int $y
     * @throws InvalidAttributeException
     * @throws InvalidLimitValueException
     */
    public function __construct($x, $y)
    {
        if ( !is_int($x) || !is_int($y)) {
            throw new InvalidAttributeException('Supplied coordinate values must be integers.');
        }
        if ( $x == 0 || $y == 0 ) {
            throw new InvalidLimitValueException('Limit coordinates cannot be zero.');
        }

        $this->xMin = 0 - $x;
        $this->xMax = $x;
        $this->yMin = 0 - $y;
        $this->yMax = $y;

    }

    /**
     * @return array
     */
    public function getLimits()
    {
        return [
            "x" => [ $this->xMin, $this->xMax ],
            "y" => [ $this->yMin, $this->yMax ],
        ];
    }

    /**
     * @param array $coordinate
     * @return bool
     */
    public function validateCoordinate(array $coordinate)
    {
        return (
            $this->withinX($coordinate[0]) &&
            $this->withinY($coordinate[1])
        );
    }

    /**
     * @param $value int
     * @return bool
     */
    private function withinX($value)
    {
        return (
            $this->xMin <= $value &&
            $this->xMax >= $value
        );
    }


    /**
     * @param $value int
     * @return bool
     */
    private function withinY($value)
    {
        return (
            $this->yMin <= $value &&
            $this->yMax >= $value
        );
    }

    public function xLimits()
    {
        return [$this->xMin, $this->xMax];
    }

    public function yLimits()
    {
        return [$this->yMin, $this->yMax];
    }
}