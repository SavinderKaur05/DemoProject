<?php

namespace App\Form;

use App\Entity\Attendance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AttendanceFormTyeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
       $builder->add('name', CollectionType::class, array(
    // each item in the array will be an "email" field
        'attr'      => array('class' => 'email-box')
    ),
);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Attendance::class,
        ]);
    }
}
