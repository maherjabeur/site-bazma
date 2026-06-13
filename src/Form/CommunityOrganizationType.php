<?php

namespace App\Form;

use App\Entity\CommunityOrganization;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommunityOrganizationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nom FR'])
            ->add('nameEn', TextType::class, ['label' => 'Nom EN', 'required' => false])
            ->add('nameAr', TextType::class, ['label' => 'Nom AR', 'required' => false, 'attr' => ['dir' => 'rtl']])
            ->add('type', TextType::class, ['label' => 'Type'])
            ->add('description', TextareaType::class, ['label' => 'Description FR', 'attr' => ['rows' => 5]])
            ->add('descriptionEn', TextareaType::class, ['label' => 'Description EN', 'required' => false, 'attr' => ['rows' => 5]])
            ->add('descriptionAr', TextareaType::class, ['label' => 'Description AR', 'required' => false, 'attr' => ['rows' => 5, 'dir' => 'rtl']])
            ->add('url', TextType::class, ['label' => 'Lien source', 'required' => false])
            ->add('imageUrl', TextType::class, ['label' => 'Image WebP', 'required' => false, 'help' => 'Chemin conseillé: /assets/nom-image.webp'])
            ->add('imageFile', FileType::class, ['label' => 'Importer une image', 'mapped' => false, 'required' => false, 'help' => 'JPG, PNG ou WebP. Le fichier sera converti en WebP.', 'attr' => ['accept' => 'image/jpeg,image/png,image/webp']])
            ->add('position', IntegerType::class, ['label' => 'Ordre d’affichage'])
            ->add('active', CheckboxType::class, ['label' => 'Afficher', 'required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => CommunityOrganization::class]);
    }
}
