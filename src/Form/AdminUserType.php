<?php

namespace App\Form;

use App\Entity\AdminUser;
use App\Security\AdminPermissionCatalog;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nom'])
            ->add('email', EmailType::class, ['label' => 'Email'])
            ->add('plainPassword', PasswordType::class, [
                'label' => $options['is_edit'] ? 'Nouveau mot de passe' : 'Mot de passe',
                'mapped' => false,
                'required' => !$options['is_edit'],
                'help' => $options['is_edit'] ? 'Laissez vide pour garder le mot de passe actuel.' : null,
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Permissions',
                'multiple' => true,
                'expanded' => true,
                'choices' => AdminPermissionCatalog::groupedChoices(),
                'help' => 'Cochez uniquement les sections et actions autorisées pour ce modérateur.',
            ])
            ->add('active', CheckboxType::class, ['label' => 'Compte actif', 'required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AdminUser::class,
            'is_edit' => false,
        ]);
        $resolver->setAllowedTypes('is_edit', 'bool');
    }
}
