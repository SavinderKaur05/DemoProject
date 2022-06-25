<?php

namespace App\Form;

use App\Entity\Students;
use App\Entity\Users;
use App\Entity\Classes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class StudentsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           ->add('Admission_Number',TextType::class,
            [
            'label'=>'Admission Number',
                'attr'=>array(
                    'style'=>'width:300px;height:40px;'
                ),
                 'required'=>false
            ])

           ->add('Name',TextType::class,
            [
            'label'=>'Student Name',
                'attr'=>array(
                    'style'=>'width:300px;height:40px;'
                ),
                 'required'=>false
            ])

            ->add('class', EntityType::class,[
                'class'=> Classes::class,
                'mapped' =>true,
                'choice_label' => function($choice){
                    return $choice->getName();
                },
                'attr' => array(
                    'class' => 'mt-1 form-control',
                    'style'=>'width:300px;height:40px;',
                    'label'=>'Student Class'
                )
            ]);
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Students::class,
        ]);
    }
}
