<?php

namespace Edgar\EzUIFavicon\Form\Type;

use Edgar\EzUISites\Form\Type\FilterSitesType;
use Liip\ImagineBundle\Form\Type\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FaviconType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'site',
                FilterSitesType::class,
                [
                    'label' => 'Site',
                    'multiple' => false,
                    'expanded' => false,
                    'required' => false,
                    'placeholder' => 'For all sites',
                ]
            )->add(
                'image',
                \Edgar\EzUIFavicon\Form\Type\ImageTypee::class,
                [
                    'image_path' => '/',
                    'image_filter' => '',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
            ]);
    }
}
