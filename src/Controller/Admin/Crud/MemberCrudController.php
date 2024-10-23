<?php

namespace App\Controller\Admin\Crud;

use App\Entity\Member\Member;
use App\Form\Type\MemberMediaType\MemberAudioType;
use App\Form\Type\MemberMediaType\MemberImageType;
use App\Form\Type\MemberMediaType\MemberPoetryType;
use App\Form\Type\MemberMediaType\MemberVideoType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;


class MemberCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Member::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Создать участника');
            });
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Участник')
            ->setEntityLabelInPlural('Участники')
            ->setPageTitle('new', 'Добавление участника')
            ->setPageTitle('edit', 'Изменение участника');
    }


    public function configureFields(string $pageName): iterable
    {
        yield FormField::addTab('Главная');
        yield IdField::new('id', 'ID')->hideOnForm();
        yield AssociationField::new('type', 'Тип')
                        ->setRequired(true);

        yield TextField::new('lastName', 'Фамилия');
        yield TextField::new('firstName', 'Имя');
        yield TextField::new('patronymic', 'Отчество');

        yield TextEditorField::new('bio', 'Биография');
        yield CollectionField::new('images', 'Изображения')
                    ->setEntryType(MemberImageType::class);

        yield DateField::new('birthDate', 'Дата рождения');
        yield DateField::new('deathDate', 'Дата Смерти');

        yield DateTimeField::new('updatedAt', 'Обновлено')
                    ->hideOnForm()
                    ->setTimezone('Europe/Moscow');



        yield FormField::addTab('Аудио');
        yield CollectionField::new('audios', 'Аудио')
                    ->setEntryType(MemberAudioType::class)->hideOnIndex();



        yield FormField::addTab('Видео');
        yield CollectionField::new('videos', 'Видео')
                    ->setEntryType(MemberVideoType::class)->hideOnIndex();



        yield FormField::addTab('Поэзия');
        yield CollectionField::new('poetries', 'Поэзия')
                    ->setEntryType(MemberPoetryType::class)->hideOnIndex();
    }
}
