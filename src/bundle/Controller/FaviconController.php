<?php

namespace Edgar\EzUIFaviconBundle\Controller;

use Edgar\EzUIFavicon\Form\Data\FaviconData;
use Edgar\EzUIFavicon\Form\Factory\FormFactory;
use Edgar\EzUIFavicon\Form\SubmitHandler;
use Edgar\EzUIFavicon\Generator\Generator;
use Edgar\EzUIFaviconBundle\Exception\FaviconException;
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

    /** @var Generator $generator */
    protected $generator;

    public function __construct(
        FormFactory $formFactory,
        SubmitHandler $submitHandler,
        TokenStorage $tokenStorage,
        NotificationHandlerInterface $notificationHandler,
        TranslatorInterface $translator,
        Generator $generator
    ) {
        $this->formFactory = $formFactory;
        $this->submitHandler = $submitHandler;
        $this->tokenStorage = $tokenStorage;
        $this->notificationHandler = $notificationHandler;
        $this->translator = $translator;
        $this->generator = $generator;
    }

    public function faviconsAction(Request $request): Response
    {
        $faviconType = $this->formFactory->buildForm(
            new FaviconData()
        );
        $faviconType->handleRequest($request);

        if ($faviconType->isSubmitted() && $faviconType->isValid()) {
            $result = $this->submitHandler->handle($faviconType, function (FaviconData $data) use ($faviconType) {
                $rootDir = $this->container->getParameter('kernel.root_dir');
                $varDir = $this->container->getParameter('ezsettings.admin_group.var_dir') . '/storage/images/' . Generator::FAVICONS_DIR . '/' . $data->getSite()->getIdentifier();
                $destFileFolder = $rootDir . '/../web/' . $varDir;

                try {
                    $data->getFile()->move($destFileFolder, $data->getFile()->getClientOriginalName());
                    $response = $this->generator->callAPI($destFileFolder . '/' . $data->getFile()->getClientOriginalName(), '/');
                    $this->generator->decodeResponse($response, $destFileFolder, $varDir);
                } catch (FaviconException $e) {
                    $this->notificationHandler->error(
                        $e->getMessage()
                    );
                }

                $this->notificationHandler->success(
                    $this->translator->trans(
                        'edgar.ezuifavicon.favicon.generate',
                        [],
                        'edgarezuifavicon'
                    )
                );

                return $this->render('@EdgarEzUIFavicon/sites/favicons.html.twig', [
                    'form' => $faviconType->createView(),
                ]);
            });

            if ($result instanceof Response) {
                return $result;
            }
        }

        return $this->render('@EdgarEzUIFavicon/sites/favicons.html.twig', [
            'form' => $faviconType->createView(),
        ]);
    }
}
