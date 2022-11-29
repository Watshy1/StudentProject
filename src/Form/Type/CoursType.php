<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, array('attr' => array(
                'class' => 'mt-2 border text-sm rounded-lg bg-gray-700 border-gray-600 placeholder-gray-400 text-white'
            ),
            'label_attr' => array(
                'class' => 'block mt-2 text-sm font-medium text-white'
            )))
            ->add('students', CollectionType::class, array(
                'entry_type' => StudentType::class,
                'entry_options' => [
                    'attr' => ['class' => 'student-box'],
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false,
                'attr' => array(
                    'class' => 'mt-2 border text-sm rounded-lg bg-gray-700 border-gray-600 placeholder-gray-400 text-white'
                ),
                'label_attr' => array(
                    'class' => 'block mt-2 text-sm font-medium text-white'
                )
            ))
            ->add('create', SubmitType::class, array('attr' => array(
                'class' => 'mt-2 text-white bg-blue-600 font-medium rounded-lg text-sm px-6 py-2.5'
            )))
        ;
    }
}