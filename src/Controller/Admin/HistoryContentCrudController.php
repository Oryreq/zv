<?php

namespace App\Controller\Admin;

use App\Entity\History\History;
use App\Form\Type\HistoryMediaType\HistoryImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;


class HistoryContentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return History::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
                    ->remove(Crud::PAGE_INDEX, Action::NEW);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('История СВО / Харовск и СВО')
            ->setPageTitle('edit', 'Изменение контента');
    }


    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('type', 'Тип')->setRequired(true);
        // TO-DO сделать вывод картинок, а не имени файла
        yield CollectionField::new('images', 'Изображения')
                ->setEntryType(HistoryImageType::class);
        yield TextEditorField::new('description', 'Описание');
    }
}
