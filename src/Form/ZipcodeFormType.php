<?php

namespace App\Form;

use App\Entity\Town;
use App\Entity\Zipcode;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ZipcodeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class, [
                'label' => 'Kod'
            ])
            ->add('town', EntityType::class, [
                'class' => Town::class,
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository -> createQueryBuilder('t')
                        ->orderBy('t.name', 'ASC');
                },
                'choice_label' => 'name',
                'label' => 'Miasto'
            ])
        ;
    }

public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Zipcode::class,
        ]);
    }
}