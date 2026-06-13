<?php

namespace App\Form;

use App\Entity\Page;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Titre FR'])
            ->add('titleEn', TextType::class, ['label' => 'Titre EN', 'required' => false])
            ->add('titleAr', TextType::class, ['label' => 'Titre AR', 'required' => false, 'attr' => ['dir' => 'rtl']])
            ->add('slug', TextType::class, ['label' => 'Slug public', 'help' => 'Exemple: histoire-bazma'])
            ->add('summary', TextType::class, ['label' => 'Résumé FR'])
            ->add('summaryEn', TextType::class, ['label' => 'Résumé EN', 'required' => false])
            ->add('summaryAr', TextType::class, ['label' => 'Résumé AR', 'required' => false, 'attr' => ['dir' => 'rtl']])
            ->add('body', TextareaType::class, ['label' => 'Contenu FR', 'attr' => ['rows' => 12]])
            ->add('bodyEn', TextareaType::class, ['label' => 'Contenu EN', 'required' => false, 'attr' => ['rows' => 8]])
            ->add('bodyAr', TextareaType::class, ['label' => 'Contenu AR', 'required' => false, 'attr' => ['rows' => 8, 'dir' => 'rtl']])
            ->add('imageUrl', TextType::class, ['label' => 'Image WebP', 'required' => false, 'help' => 'Chemin conseillé: /assets/nom-image.webp'])
            ->add('imageFile', FileType::class, ['label' => 'Importer une image', 'mapped' => false, 'required' => false, 'help' => 'JPG, PNG ou WebP. Le fichier sera converti en WebP.', 'attr' => ['accept' => 'image/jpeg,image/png,image/webp']])
            ->add('position', IntegerType::class, ['label' => 'Ordre d’affichage'])
            ->add('published', CheckboxType::class, ['label' => 'Publié', 'required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Page::class]);
    }
}
