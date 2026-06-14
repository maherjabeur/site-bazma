<?php

namespace App\Form;

use App\Entity\SocialLink;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SocialLinkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('platform', TextType::class, ['label' => 'Plateforme'])
            ->add('category', TextType::class, ['label' => 'Catégorie'])
            ->add('title', TextType::class, ['label' => 'Titre FR'])
            ->add('titleEn', TextType::class, ['label' => 'Titre EN', 'required' => false])
            ->add('titleAr', TextType::class, ['label' => 'Titre AR', 'required' => false, 'attr' => ['dir' => 'rtl']])
            ->add('summary', TextareaType::class, ['label' => 'Résumé FR', 'attr' => ['rows' => 4]])
            ->add('summaryEn', TextareaType::class, ['label' => 'Résumé EN', 'required' => false, 'attr' => ['rows' => 4]])
            ->add('summaryAr', TextareaType::class, ['label' => 'Résumé AR', 'required' => false, 'attr' => ['rows' => 4, 'dir' => 'rtl']])
            ->add('url', TextType::class, ['label' => 'Adresse du lien'])
            ->add('imageUrl', TextType::class, ['label' => 'Image WebP', 'required' => false, 'help' => 'Chemin conseillé: /assets/nom-image.webp'])
            ->add('imageFile', FileType::class, ['label' => 'Importer une image', 'mapped' => false, 'required' => false, 'help' => 'JPG, PNG ou WebP. Le fichier sera converti en WebP.', 'attr' => ['accept' => 'image/jpeg,image/png,image/webp']])
            ->add('position', IntegerType::class, ['label' => 'Ordre d’affichage'])
            ->add('featured', CheckboxType::class, ['label' => 'Afficher sur l’accueil', 'required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => SocialLink::class]);
    }
}
