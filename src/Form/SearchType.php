<?php

namespace App\Form;

use App\Entity\CompanyActivity;
use App\Entity\UnderActivity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('companyActivities', EntityType::class, [
                'mapped' => false,
                'class' => CompanyActivity::class,
                'choice_label' => 'name',
                'placeholder' => 'Veuillez choisir l\'activité d\'entreprise à recherché',
            ])
            ->add('underActivities', HiddenType::class)
        ;
        $formModifier = function(FormInterface $form, CompanyActivity $activity = null) {
            $underActivities = null === $activity ? [] : $activity->getUnderActivities();

            $form->add('underActivities', EntityType::class, [
                'class' => UnderActivity::class,
                'expanded' => true,
                'multiple' => true,
                'required' => false,
                'empty_data'=>true,
                'choices' => $underActivities,
                'choice_attr' => array('checked'=>true),
                'choice_label' => 'name',
                'placeholder' => 'choisir une sous activité',
            ]); 
        };

        $builder->get('companyActivities')->addEventListener(
            FormEvents::POST_SUBMIT,
            function(FormEvent $event) use ($formModifier) {
                $activity = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $activity);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        
    }
}

