<?php

namespace Edgar\EzUIFaviconBundle\Controller;

use Edgar\EzUIFavicon\Form\Data\FaviconData;
use Edgar\EzUIFavicon\Form\Factory\FormFactory;
use Edgar\EzUIFavicon\Form\SubmitHandler;
use EzSystems\EzPlatformAdminUi\Notification\NotificationHandlerInterface;
use EzSystems\EzPlatformAdminUiBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Translation\TranslatorInterface;

class FaviconController extends Controller
{
    /** @var FormFactory */
    protected $formFactory;

    /** @var SubmitHandler */
    protected $submitHandler;

    /** @var TokenStorage $tokenStorage */
    protected $tokenStorage;

    /** @var NotificationHandlerInterface $notificationHandler */
    protected $notificationHandler;

    /** @var TranslatorInterface  */
    protected $translator;

    public function __construct(
        FormFactory $formFactory,
        SubmitHandler $submitHandler,
        TokenStorage $tokenStorage,
        NotificationHandlerInterface $notificationHandler,
        TranslatorInterface $translator
    ) {
        $this->formFactory = $formFactory;
        $this->submitHandler = $submitHandler;
        $this->tokenStorage = $tokenStorage;
        $this->notificationHandler = $notificationHandler;
        $this->translator = $translator;
    }

    public function faviconsAction(Request $request): Response
    {
        $faviconType = $this->formFactory->buildForm(
            new FaviconData()
        );
        $faviconType->handleRequest($request);

        return $this->render('@EdgarEzUIFavicon/sites/favicons.html.twig', [
            'form' => $faviconType->createView(),
        ]);
    }
}
