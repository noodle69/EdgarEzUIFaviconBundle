<?php

namespace Edgar\EzUIFavicon\Form\Type;

use Edgar\EzUISites\Form\Constraints\SiteConstraint;
use Edgar\EzUISites\Form\Type\FilterSitesType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

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
                    'placeholder' => 'All sites',
                    'constraints' => [new SiteConstraint()],
                ]
            )->add(
                'file',
                FileType::class,
                [
                    'label' => /** @Desc("File") */ 'content.field_type.binary_base.file',
                    'required' => true,
                    'constraints' => [
                        new Assert\File([
                            'maxSize' => $this->getMaxUploadSize(),
                        ]),
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
            ]);
    }

    private function getMaxUploadSize()
    {
        static $value = null;
        if ($value === null) {
            $value = $this->str2bytes(ini_get('upload_max_filesize'));
        }

        return $value;
    }

    private function str2bytes($str)
    {
        $str = strtoupper(trim($str));

        $value = substr($str, 0, -1);
        $unit = substr($str, -1);
        switch ($unit) {
            case 'G':
                $value *= 1024;
            case 'M':
                $value *= 1024;
            case 'K':
                $value *= 1024;
        }

        return (int) $value;
    }
}
