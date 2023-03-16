<?php

namespace App\Form;

use App\Entity\Produitf;
use App\Entity\Sortief;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortiefType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateS', DateType::class, array('label'=>'Date de sortie', 'attr'=>array('require'=>'require','class'=>'form-control form-group')))
            ->add('categorie', TextType::class, array('label'=>'Categorie du produit', 'attr'=>array('require'=>'require','class'=>'form-control form-group')))
            ->add('qtS', TextType::class, array('label'=>'Quantite sortie', 'attr'=>array('require'=>'require','class'=>'form-control form-group')))
            ->add('produit', EntityType::class, array('class'=>Produitf::class,'label'=>'Libelle du produit', 'attr'=>array('require'=>'require','class'=>'form-control form-group')))
            ->add('Valider', SubmitType::class, array('attr'=>array('class'=>'btn btn-success form-group',)))    
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortief::class,
        ]);
    }
}
