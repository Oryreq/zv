<?php

namespace App\Form\Type\MemberMediaType;

use App\Entity\Member\MemberMediaType\MemberPoetry;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\TextEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class MemberPoetryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Название',
                'empty_data' => '',
            ])
            ->add('description', TextType::class, [
                'label' => 'Описание',
                'empty_data' => '',
            ])
            ->add('text', TextEditorType::class, [
                'label' => 'Текст',
                'empty_data' => '',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MemberPoetry::class,
        ]);
    }
}