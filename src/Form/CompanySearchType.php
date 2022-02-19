<?php

namespace App\Form;

use App\Entity\CompanySearch;
use App\Entity\CompanyActivity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CompanySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nameActivity', EntityType::class, [
                'class' => CompanyActivity::class, 
                'choice_label' => 'name',
                'placeholder' => 'Activités',
                'label' => false
            ])
            ->add('lat', HiddenType::class)
            ->add('lng', HiddenType::class)
            ->add('distance', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    '10 km' => 10,
                    '50km' => 50
                ]
            ])
            ->add('address', TextType::class, [
                'mapped' => false,
                'label' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CompanySearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
