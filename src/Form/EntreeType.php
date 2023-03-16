<?php

namespace App\Form;

use App\Entity\Entree;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntreeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateE', DateType::class, array('label'=>'Date d\'entree', 'attr'=>array('require'=>'require','class'=>'form-control form-group')))
            ->add('categorie', TextType::class, array('label'=>'Categorie du produit', 'attr'=>array('require'=>'require','class'=>'form-control form-group')))
            ->add('qtE', TextType::class, array('label'=>'Quantite entree', 'attr'=>array('require'=>'require','class'=>'form-control form-group')))
            ->add('produit', EntityType::class, array('class'=>Produit::class,'label'=>'Libelle du produit', 'attr'=>array('require'=>'require','class'=>'form-control form-group')))
            ->add('Valider', SubmitType::class, array('attr'=>array('class'=>'btn btn-success form-group',)))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entree::class,
        ]);
    }
}
