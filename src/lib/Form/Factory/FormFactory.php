<?php

namespace Edgar\EzUIFavicon\Form\Factory;

use Edgar\EzUIFavicon\Form\Data\FaviconData;
use Edgar\EzUIFavicon\Form\Type\FaviconType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class FormFactory
{
    /** @var FormFactoryInterface $formFactory */
    protected $formFactory;

    /**
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function buildForm(
        FaviconData $data,
        ?string $name = null
    ): ?FormInterface {
        $name = $name ?: 'favicons';

        return $this->formFactory->createNamed(
            $name,
            FaviconType::class,
            $data,
            [
                'method' => Request::METHOD_GET,
                'csrf_protection' => false,
            ]
        );
    }
}
