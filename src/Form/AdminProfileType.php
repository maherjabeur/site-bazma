<?php

namespace App\Form;

use App\Entity\AdminUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nom complet'])
            ->add('email', EmailType::class, ['label' => 'Email'])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Nouveau mot de passe',
                'mapped' => false,
                'required' => false,
                'help' => 'Laissez vide pour garder le mot de passe actuel.',
            ])
            ->add('profession', TextType::class, ['label' => 'Profession', 'required' => false])
            ->add('facebookUrl', TextType::class, ['label' => 'Lien profil Facebook', 'required' => false, 'help' => 'Exemple: https://www.facebook.com/nom.du.profil'])
            ->add('profileImageUrl', TextType::class, ['label' => 'Photo de profil', 'required' => false, 'help' => 'Chemin local /uploads/... ou /assets/...'])
            ->add('profileImageFile', FileType::class, ['label' => 'Importer une photo de profil', 'mapped' => false, 'required' => false, 'help' => 'JPG, PNG ou WebP. Le fichier sera converti en WebP.', 'attr' => ['accept' => 'image/jpeg,image/png,image/webp']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => AdminUser::class]);
    }
}
