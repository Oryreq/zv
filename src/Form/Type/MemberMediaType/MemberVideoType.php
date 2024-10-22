<?php

namespace App\Form\Type\MemberMediaType;

use App\Entity\Member\MemberMediaType\MemberVideo;
use App\Form\Type\Service\FormHelpBuilder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Service\Attribute\Required;
use Vich\UploaderBundle\Form\Type\VichFileType;


class MemberVideoType extends AbstractType
{
    #[Required]
    public FormHelpBuilder $formHelpBuilder;


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $videoExtensions = ['*.mp4', '*.webm'];
        $helpHtmlForm =  $this->formHelpBuilder->buildHelpAsHtml($videoExtensions);

        $builder
            ->add('file', VichFileType::class, [
                'label' => 'Видео',
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
            'data_class' => MemberVideo::class,
        ]);
    }
}