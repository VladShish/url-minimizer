<?php


namespace App\Form\Type;

use App\Entity\DateTimeExt;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Url as UrlValidator;

/**
 * Class UrlMinimizedType
 * @package App\Form\Type
 */
class UrlMinimizedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url', TextType::class, [
                'constraints' => [new UrlValidator()]
            ])
            ->add('date_expire', DateTimeType::class, [
                'data' => new DateTimeExt('now'),
            ])
            ->add('submit', SubmitType::class)
        ;
    }
}
