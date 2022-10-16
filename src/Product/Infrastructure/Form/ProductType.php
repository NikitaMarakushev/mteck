<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Form;

use App\Product\Domain\Entity\ProductCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Название',
                'attr' => ['class' => 'form-control-sm'],
            ])
            ->add('description', TextType::class, [
                'label' => 'Описание',
                'attr' => ['class' => 'form-control-sm'],
            ])
            ->add('price', TextType::class, [
                'label' => 'Цена',
                'attr' => ['class' => 'form-control-sm'],
            ])
            ->add('image', TextType::class, [
                'label' => 'Изображение',
                'attr' => ['class' => 'form-control-sm'],
            ])
            ->add('category', ChoiceType::class, [
                'label' => 'Категория',
                'choices' => $options['categories_choices'],
                'expanded' => false,
                'multiple' => true,
                'attr' => ['class' => 'form-select-sm multiple-pillow', 'size' => '4'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'categories_choices' => null
        ]);
    }
}