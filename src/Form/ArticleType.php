<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Article;
use App\Entity\Categorie;
use App\Form\CategorieType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('contenu')
            ->add('auteur', EntityType::class, [
                'placeholder' => 'Choisissez un auteur',
                'class' => Auteur::class,
                'choice_label' => 'fullName',
                'required' => false,
            ])
            ->add('categories', EntityType::class, [
                'label' => 'Choisissez un ou plusieurs categorie',
                'class' => Categorie::class,
                'choice_label' => 'nom',
                'required' => false,
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('envoyer', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
