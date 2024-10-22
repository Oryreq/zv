<?php

namespace App\Form\Type\HistoryMediaType;

use App\Entity\History\HistoryMediaType\HistoryImage;
use App\Form\Type\Service\FormHelpBuilder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Service\Attribute\Required;
use Vich\UploaderBundle\Form\Type\VichImageType;


class HistoryImageType extends AbstractType
{
    #[Required]
    public FormHelpBuilder $formHelpBuilder;


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $imageExtensions = ['*.jpg', '*.jpeg', '*.png', '*.jiff', '*.webp'];
        $helpHtmlForm =  $this->formHelpBuilder->buildHelpAsHtml($imageExtensions);

        $builder
            ->add('file', VichImageType::class, [
                'label' => 'Изображение',
                'empty_data' => '',
                'allow_delete' => false,
                'help' => $helpHtmlForm,
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