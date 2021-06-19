<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Email;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('CompanyName', TextType::class, [
                'constraints' => [
                    // Regex ftw 😎
                    new Regex("/^.{2,50}+$/")
                ],
                'required' => true,
                'label' => 'Nom de l\'entreprise',
            ])
            ->add('ContactName', TextType::class, [
                'constraints' => [
                    new Regex("/^[a-zA-Z-'\s]{2,50}+$/")
                ],
                'required' => true,
                'label' => 'Nom du contact',
            ])
            ->add('ContactEmail', TextType::class, [
                'constraints' => [
                    new Email()
                ],
                'required' => false,
                'label' => 'Email de contact',
            ])
            ->add('ContactPhone', TextType::class, [
                'constraints' => [
                    new Regex("/^([0-9]{10})|\+([0-9]{11})+$/")
                ],
                'required' => false,
                'label' => 'Numéro de téléphone du contact',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
