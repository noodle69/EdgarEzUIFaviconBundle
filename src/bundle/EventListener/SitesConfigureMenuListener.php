<?php

namespace Edgar\EzUIFaviconBundle\EventListener;

use eZ\Publish\API\Repository\PermissionResolver;
use Edgar\EzUISitesBundle\EventListener\ConfigureMenuListener;
use EzSystems\EzPlatformAdminUi\Menu\Event\ConfigureMenuEvent;
use JMS\TranslationBundle\Model\Message;
use JMS\TranslationBundle\Translation\TranslationContainerInterface;

class SitesConfigureMenuListener implements TranslationContainerInterface
{
    const ITEM_SITES_FAVICON = 'main__sites__favicon';

    /** @var PermissionResolver */
    private $permissionResolver;

    /**
     * ConfigureMenuListener constructor.
     *
     * @param PermissionResolver $permissionResolver
     */
    public function __construct(
        PermissionResolver $permissionResolver
    ) {
        $this->permissionResolver = $permissionResolver;
    }

    /**
     * @param ConfigureMenuEvent $event
     */
    public function onMenuConfigure(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu()->getChild(ConfigureMenuListener::ITEM_SITES);

        if ($this->permissionResolver->hasAccess('uifavicon', 'generate')) {
            $menu->addChild(
                self::ITEM_SITES_FAVICON,
                [
                    'route' => 'edgar.ezuifavicon.favicons',
                    'extras' => ['icon' => 'pin'],
                ]
            );
        }
    }

    /**
     * @return array
     */
    public static function getTranslationMessages(): array
    {
        return [
            (new Message(self::ITEM_SITES_FAVICON, 'messages'))->setDesc('Favicons'),
        ];
    }
}
