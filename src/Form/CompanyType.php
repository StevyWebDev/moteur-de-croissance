<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\CompanyActivity;
use App\Entity\UnderActivity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyType extends AbstractType
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
            ->add('lat', HiddenType::class)
            ->add('lng', HiddenType::class)
            ->add('phone', TelType::class)
            ->add('email', EmailType::class)
            ->add('logo', FileType::class)
            ->add('companyActivities', EntityType::class, [
                'mapped' => false,
                'class' => CompanyActivity::class,
                'choice_label' => 'name',
                'placeholder' => 'Activité',
                'label' => 'Activité',
            ])
            ->add('underActivities', HiddenType::class, [
                
                'label' => 'Sous-activités',
            ])
        ;

        $formModifier = function(FormInterface $form, CompanyActivity $activity = null) {
            $underActivities = null === $activity ? [] : $activity->getUnderActivities();

            $form->add('underActivities', EntityType::class, [
                'class' => UnderActivity::class,
                'choices' => $underActivities,
                'choice_label' => 'name',
                'placeholder' => 'choisir une sous activité',
                'multiple' => true
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
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
