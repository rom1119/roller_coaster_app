<?php

namespace App\Form;

use App\Domain\Model\Wagon;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateWagonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ilosc_miejsc', IntegerType::class, [
                'property_path' => 'numberOfPlaces'
            ])
            ->add('predkosc_wagonu', NumberType::class, [
                'property_path' => 'speed'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Wagon::class,
            'csrf_protection' => false,
        ));
    }
}
