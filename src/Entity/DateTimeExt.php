<?php


namespace App\Entity;

/**
 * Class DateTimeExt
 * @package App\Entity
 */
class DateTimeExt extends \DateTime
{

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->format('Y-m-d H:i:s');
    }
}
