<?php

namespace App\Form;

use App\Entity\Student;
use App\Entity\Classes;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class StudentFormType extends AbstractType
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
             
            ->add("inputName",TextType::class, array("mapped"=>false, "label"=>'Student Name'))

            ->add('classId', EntityType::class,[
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
                 
            //->add('Student_Name')
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
