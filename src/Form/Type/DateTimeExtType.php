<?php


namespace App\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class DateTimeExtType extends DateTimeType
{
    public function getBlockPrefix()
    {
        return 'datetimeext';
    }
}
