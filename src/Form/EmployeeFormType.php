<?php

namespace App\Form;

use App\Entity\Users;
use App\Entity\Classes;
use App\Entity\Employee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EmployeeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           ->add('EmployeeCode',TextType::class,
            [
            'label'=>'Employee Code',
                'attr'=>[
                    'style'=>'width:300px;height:40px;'
                ]
            ])
             
            ->add("inputName",TextType::class, array("mapped"=>false, "label"=>'Employee Name'))

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
            'data_class' => Employee::class,
        ]);
    }
}
