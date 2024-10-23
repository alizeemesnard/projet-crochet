<?php

namespace App\Form;

use App\Entity\CrochetPattern;
use App\Entity\patternCollection;
use App\Entity\Portfolio;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CrochetPatternType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name')
            ->add('HookSize')
            ->add('Category')
            ->add('Language')
            ->add('Image')
            ->add('Designer')
            ->add('patternCollection', EntityType::class, [
                'class' => patternCollection::class,
                'choice_label' => 'id',
            ])
            ->add('portfolios', EntityType::class, [
                'class' => Portfolio::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CrochetPattern::class,
        ]);
    }
}
