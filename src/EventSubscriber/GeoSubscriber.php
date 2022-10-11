<?php

namespace App\EventSubscriber;

use App\Service\RegionalService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class GeoSubscriber implements EventSubscriberInterface
{
    private const COOKIE_NAME = 'cookieconsent_status';
    private const COOKIE_VALUE = 'dismiss';
    private const COOKIE_TTL = '+1 minute';

    public function __construct(private RegionalService $service)
    {
    }

    public function onKernelController()
    {
        if (!array_key_exists(self::COOKIE_NAME, $_COOKIE) && !$this->isVisitorFromEurope()) {
            setcookie(self::COOKIE_NAME, self::COOKIE_VALUE, strtotime(self::COOKIE_TTL));
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }

    private function isVisitorFromEurope(): bool
    {
        $geoInfo = $this->service->getVisitorGeoInfo();

        return array_key_exists('continent', $geoInfo)
            && 'Europe' == $geoInfo['continent'];
    }
}
