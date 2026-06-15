<?php

namespace App\Form;

use App\Entity\GalleryImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GalleryImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Titre FR'])
            ->add('titleEn', TextType::class, ['label' => 'Titre EN', 'required' => false])
            ->add('titleAr', TextType::class, ['label' => 'Titre AR', 'required' => false, 'attr' => ['dir' => 'rtl']])
            ->add('imageUrl', TextType::class, ['label' => 'Chemin image local', 'required' => false, 'help' => 'Front public: utilisez /uploads/... ou /assets/.... Les URLs externes ne sont pas affichées dans la galerie.'])
            ->add('imageFile', FileType::class, ['label' => 'Importer une image locale', 'mapped' => false, 'required' => false, 'help' => 'JPG, PNG ou WebP. Le fichier sera converti en WebP optimisé et stocké dans /uploads.', 'attr' => ['accept' => 'image/jpeg,image/png,image/webp']])
            ->add('credit', TextType::class, ['label' => 'Crédit', 'required' => false])
            ->add('sourceUrl', TextType::class, ['label' => 'Lien source interne CMS', 'required' => false, 'help' => 'Conservé pour traçabilité. Non affiché dans la galerie publique.'])
            ->add('position', IntegerType::class, ['label' => 'Ordre d’affichage', 'help' => 'Plus le chiffre est petit, plus l’image remonte dans la galerie.'])
            ->add('featured', CheckboxType::class, ['label' => 'Mise en avant galerie et accueil', 'required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => GalleryImage::class]);
    }
}
