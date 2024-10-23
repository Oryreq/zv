<?php

namespace App\Controller\Admin\Crud;

use App\Entity\History\History;
use App\Form\Type\HistoryMediaType\HistoryImageType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use Symfony\Contracts\Service\Attribute\Required;


class HistoryContentCrudController extends AbstractCrudController
{
    #[Required]
    public EntityManagerInterface $entityManager;

    private int $contentCountLimit = 2;

    public static function getEntityFqcn(): string
    {
        return History::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $content = $this->entityManager->getRepository(History::class)->findAll();
        if (count($content) === $this->contentCountLimit) {
            return $actions->remove(Crud::PAGE_INDEX, Action::NEW);
        }

        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Создать контент');
            });
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('История СВО / Харовск и СВО')
            ->setPageTitle('edit', 'Изменение контента')
            ->setPageTitle('new', 'Создать новый контент');
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
