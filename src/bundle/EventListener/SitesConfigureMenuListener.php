<?php

namespace Edgar\EzUIFaviconBundle\EventListener;

use Edgar\EzUISitesBundle\EventListener\ConfigureMenuListener;
use EzSystems\EzPlatformAdminUi\Menu\Event\ConfigureMenuEvent;
use JMS\TranslationBundle\Model\Message;
use JMS\TranslationBundle\Translation\TranslationContainerInterface;

class SitesConfigureMenuListener implements TranslationContainerInterface
{
    const ITEM_SITES_FAVICON = 'main__sites__favicon';

    /**
     * @param ConfigureMenuEvent $event
     */
    public function onMenuConfigure(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu()->getChild(ConfigureMenuListener::ITEM_SITES);

        $menu->addChild(
            self::ITEM_SITES_FAVICON,
            [
                'route' => 'edgar.ezuifavicon.favicons',
                'extras' => ['icon' => 'pin'],
            ]
        );
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
