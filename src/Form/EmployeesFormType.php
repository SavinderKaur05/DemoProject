<?php

namespace App\Form;

use App\Entity\Employees;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class EmployeesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
         $builder
           ->add('EmployeeCode',TextType::class,
            [
            'label'=>'Employee Code',
                'attr'=>array(
                    'style'=>'width:300px;height:40px;'
                ),
                 'required'=>false
            ])

           ->add('Name',TextType::class,
            [
            'label'=>'Employee Name',
                'attr'=>array(
                    'style'=>'width:300px;height:40px;'
                ),
                 'required'=>false
            ])

             ->add('role', ChoiceType::class,
            [
            'mapped' =>false,
             'choices'  => 
             [
             'Teacher' => 'Teacher',
             'Admin' => 'Admin',
             ],
             ],
            
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employees::class,
        ]);
    }
}
