<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 07/04/2018
 * Time: 22:34
 */

namespace Edgar\EzUIFavicon\Form\Type;


use Symfony\Component\Form\Extension\Core\Type\FileType;

class ImageType extends \Liip\ImagineBundle\Form\Type\ImageType
{
    public function getParent()
    {
        return FileType::class;
    }
}
