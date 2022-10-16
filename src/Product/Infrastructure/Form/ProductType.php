<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

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
            ->add('category', TextType::class, [
                'label' => 'Категория',
                'attr' => ['class' => 'form-control-sm']
            ])
        ;
    }
}