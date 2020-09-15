<?php


namespace App\Service;

/**
 * Class UserIdGenerator
 * @package App\Service
 */
class UserIdGenerator
{

    /**
     * @return int
     */
    public static function generate()
    {
        return rand(1, 1000000000);
    }
}
