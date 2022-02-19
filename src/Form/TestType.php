<?php

namespace App\Form;

use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('siren_number')
            ->add('number_tva')
            ->add('adress')
            ->add('number_postal')
            ->add('city')
            ->add('number_naf')
            ->add('phone')
            ->add('email')
            ->add('user')
            ->add('companyActivities')
            ->add('underActivities')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
