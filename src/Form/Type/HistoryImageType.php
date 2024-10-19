<?php

namespace App\Form\Type;

use App\Entity\HistoryImage;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;


class HistoryImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $styles = 'border-radius: 4px;
                   background-color: #171717;
                   color: #FF9A62;
                   padding: 1px 5px 1px 5px;
                   margin-left: 8px;
                   text-align: center';

        $extensionToHtml = function ($extension) use ($styles) {
            return '<div style="' . $styles . '">' .$extension . '</div>';
        };


        $imageExtensions = new ArrayCollection(['*.jpg', '*.jpeg', '*.png', '*.jiff', '*.webp']);
        $htmlExtensions = $imageExtensions
                            ->map(function($extension) use (&$extensionToHtml) {
                                return $extensionToHtml($extension);
                            })
                            ->reduce(function($accumulator, $value) {
                                return $accumulator.''.$value;
                            });


        $builder
            ->add('file', VichImageType::class, [
                'label' => 'Изображение',
                'empty_data' => '',
                'allow_delete' => false,
                'help' => '<div style="display: flex; text-align: center;">'. $htmlExtensions.'</div>',
            ])
            ->add('name', TextType::class, [
                'label' => 'Название',
                'empty_data' => '',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => HistoryImage::class,
        ]);
    }
}