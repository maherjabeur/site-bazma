<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Titre FR'])
            ->add('titleEn', TextType::class, ['label' => 'Titre EN', 'required' => false])
            ->add('titleAr', TextType::class, ['label' => 'Titre AR', 'required' => false, 'attr' => ['dir' => 'rtl']])
            ->add('slug', TextType::class, ['label' => 'Slug public', 'help' => 'Exemple: fete-du-village-2026'])
            ->add('category', TextType::class, ['label' => 'Catégorie'])
            ->add('eventDate', DateType::class, ['label' => 'Date', 'required' => false, 'widget' => 'single_text'])
            ->add('location', TextType::class, ['label' => 'Lieu'])
            ->add('imageUrl', TextType::class, ['label' => 'Image WebP', 'required' => false])
            ->add('imageFile', FileType::class, ['label' => 'Importer une image', 'mapped' => false, 'required' => false, 'help' => 'JPG, PNG ou WebP. Conversion automatique en WebP.', 'attr' => ['accept' => 'image/jpeg,image/png,image/webp']])
            ->add('excerpt', TextareaType::class, ['label' => 'Résumé court FR', 'required' => false, 'attr' => ['rows' => 3]])
            ->add('excerptEn', TextareaType::class, ['label' => 'Résumé court EN', 'required' => false, 'attr' => ['rows' => 3]])
            ->add('excerptAr', TextareaType::class, ['label' => 'Résumé court AR', 'required' => false, 'attr' => ['rows' => 3, 'dir' => 'rtl']])
            ->add('description', TextareaType::class, ['label' => 'Description FR', 'attr' => ['rows' => 8]])
            ->add('descriptionEn', TextareaType::class, ['label' => 'Description EN', 'required' => false, 'attr' => ['rows' => 6]])
            ->add('descriptionAr', TextareaType::class, ['label' => 'Description AR', 'required' => false, 'attr' => ['rows' => 6, 'dir' => 'rtl']])
            ->add('sourceUrl', TextType::class, ['label' => 'Lien source', 'required' => false])
            ->add('position', IntegerType::class, ['label' => 'Ordre d’affichage'])
            ->add('featured', CheckboxType::class, ['label' => 'Mise en avant', 'required' => false])
            ->add('published', CheckboxType::class, ['label' => 'Publié', 'required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Event::class]);
    }
}
