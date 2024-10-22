<?php

namespace App\Form\Type\MemberMediaType;

use App\Entity\Member\MemberMediaType\MemberAudio;
use App\Form\Type\Service\FormHelpBuilder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Service\Attribute\Required;
use Vich\UploaderBundle\Form\Type\VichFileType;


class MemberAudioType extends AbstractType
{
    #[Required]
    public FormHelpBuilder $formHelpBuilder;


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $audioExtensions = ['*.wav', '*.mp3', '*.mpeg'];
        $helpHtmlForm =  $this->formHelpBuilder->buildHelpAsHtml($audioExtensions);

        $builder
            ->add('file', VichFileType::class, [
                'label' => 'Аудио',
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
            'data_class' => MemberAudio::class,
        ]);
    }
}