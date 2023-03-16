<?php

namespace App\Form;

use App\Entity\Produitf;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitfType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('categorie', TextType::class, array('label'=>'Categorie du produit', 'attr'=>array('require'=>'require','class'=>'form-control form-group')))
            ->add('libelle', TextType::class, array('label'=>'Libelle du produit', 'attr'=>array('require'=>'require','class'=>'form-control form-group')))
            ->add('qtStock', TextType::class, array('label'=>'Quantite en stock', 'attr'=>array('require'=>'require','class'=>'form-control form-group')))
            ->add('Valider', SubmitType::class, array('attr'=>array('class'=>'btn btn-success form-group')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produitf::class,
        ]);
    }
}
