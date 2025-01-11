<?php

namespace App\Form;

use App\Domain\Model\Coaster;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateCoasterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('liczba_personelu', IntegerType::class, [
                'property_path' => 'numberOfStaff'
            ])
            ->add('liczba_klientow', IntegerType::class, [
                'property_path' => 'numberOfCustomers'
            ])
            ->add('dl_trasy', IntegerType::class, [
                'property_path' => 'distance'
            ])
            ->add('godziny_od', TimeType::class, [
                'property_path' => 'hourFrom',
                'input' => 'string',
                'input_format' => 'H:i',
            ])
            ->add('godziny_do', TimeType::class, [
                'property_path' => 'hourTo',
                'input' => 'string',
                'input_format' => 'H:i',
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Coaster::class,
            'csrf_protection' => false,
        ));
    }
}
