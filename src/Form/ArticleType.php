<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Category;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Length;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        // ->add('lastname', TextType::class, ['label'=>'Votre nom','constraints'=> new Length(['min' => 2 ,'max'=> 30]), 'attr'=>['placeholder'=>' Merci de saisir votre nom']] )
            ->add('titre',  Null, [
                'attr' =>[
                    'placeholder' => "Ajouter un titre a l'article"
                ]
            ],)
            ->add('contenu')
            ->add('dateCreation', null,[
                'widget' => 'single_text'
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'multiple'=> true,
                'by_reference' => false
            ])
            ->add('brouillon', SubmitType::class, [
                'label' => 'Enregistrer en brouillon'
            ])
            ->add('publier', SubmitType::class, [
                'label' => 'a publier'
            ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}

