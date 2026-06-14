<?php

namespace App\Form;

use App\Entity\SiteSetting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SiteSettingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('settingKey', TextType::class, ['label' => 'Cle'])
            ->add('settingValue', TextareaType::class, ['label' => 'Valeur', 'attr' => ['rows' => 6]])
            ->add('imageFile', FileType::class, [
                'label' => 'Importer une image',
                'mapped' => false,
                'required' => false,
                'help' => 'Optionnel pour les cles image comme og_image. JPG, PNG ou WebP converti automatiquement.',
                'attr' => ['accept' => 'image/jpeg,image/png,image/webp'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => SiteSetting::class]);
    }
}
