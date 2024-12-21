<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Sylius\Bundle\UiBundle\Event\TemplateEvent;

final class JavaScriptHookSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            'sylius.shop.layout.javascripts' => 'onLayoutJavascripts',
        ];
    }

    public function onLayoutJavascripts(TemplateEvent $event): void
    {
        $route = $event->getRequest()->attributes->get('_route');

        // Check if we're on the product detail or cart summary page
        if (in_array($route, ['sylius_shop_product_show', 'sylius_shop_cart_summary'], true)) {
            $event->addAsset('@SyliusShopBundle/Resources/public/js/quantity-alert.js');
        }
    }
}
