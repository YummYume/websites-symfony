<?php

namespace App\Form;

use App\Entity\Website;
use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Constraints\Regex;

class WebsiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Name', TextType::class, [
                'constraints' => [
                    new Regex("/^.{2,50}+$/")
                ],
                'required' => true,
                'label' => 'Nom du site',
            ])
            ->add('Link', TextType::class, [
                'constraints' => [
                    new Url()
                ],
                'required' => true,
                'label' => 'Lien vers le site',
            ])
            ->add('Client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'companyName',
                'required' => true,
                'label' => 'Client',
            ])
            ->add('PHP', ChoiceType::class, [
                'required' => false,
                'choices'  => [
                    '7.4' => "7.4",
                    '7.3' => "7.3",
                    '7.2' => "7.2",
                    '7.1' => "7.1",
                    '7.0' => "7.0",
                ],
                'label' => 'Version PHP',
                'empty_data' => null,
                'placeholder' => 'Aucune',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Website::class,
        ]);
    }
}
