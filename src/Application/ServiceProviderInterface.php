<?php


namespace App\Application;

/**
 * Interface ServiceProviderInterface
 * @package App\Application
 */
interface ServiceProviderInterface
{

    /**
     * @param array $options
     * @return array
     */
    public function execute(array $options) : array;
}
