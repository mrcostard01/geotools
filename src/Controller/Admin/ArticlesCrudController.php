<?php

namespace App\Controller\Admin;

use App\Entity\Articles;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Vich\UploaderBundle\Form\Type\VichImageType;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ArticlesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Articles::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
                ->setEntityLabelinSingular('Article')
                ->setEntityLabelinPlural('Articles')
                ->setPageTitle('index', 'Geotools - administration des utilisateurs')
             ->setPaginatorPageSize(10)
             
             ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');

    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                    ->hideOnIndex()
                    ->hideOnForm(),
            TextField::new('imageFile')
                    ->setFormType(VichImageType::class) 
                    ->hideOnIndex()
                      ,
            TextField::new('titrearticlea'),
            TextField::new('resumearticlea'),
            TextField::new('textearticlea')
                    ->setFormType(CKEditorType::class),
            
        ];
    }
    
}
