<?php


namespace App\Service;

use App\Entity\MinimizeUrl;

/**
 * Class Minimizer
 * @package App\Service
 */
class Minimizer
{

    /**
     * @param MinimizeUrl $minimizeUrl
     * @return string
     */
    public static function minimize(
        MinimizeUrl $minimizeUrl
    ) {
        return hash('crc32', $minimizeUrl->getUrl() . $minimizeUrl->getUserId());
    }
}
