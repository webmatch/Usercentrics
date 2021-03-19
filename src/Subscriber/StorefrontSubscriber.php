<?php declare(strict_types=1);

namespace Webmatch\Usercentrics\Subscriber;

use Shopware\Core\System\SystemConfig\SystemConfigService;
use Shopware\Storefront\Event\StorefrontRenderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class StorefrontSubscriber implements EventSubscriberInterface
{
    protected const CONFIG_NAME = 'WebmatchUsercentrics';

    protected SystemConfigService $configService;

    public function __construct(SystemConfigService $configService)
    {
        $this->configService = $configService;
    }

    public static function getSubscribedEvents()
    {
        return [
            StorefrontRenderEvent::class => 'onRender',
        ];
    }

    public function onRender(StorefrontRenderEvent $event): void
    {
        $config = $this->configService->get(self::CONFIG_NAME);

        if ($config === null || !isset($config['config'])) {
            return;
        }

        $event->setParameter(self::CONFIG_NAME, $config['config']);
    }
}
