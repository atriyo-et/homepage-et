<?php

namespace App\EventSubscriber;

use App\Service\RegionalService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class LocaleSubscriber implements EventSubscriberInterface
{
    private const GERMAN_SPEAKING_COUNTRY_CODES = ['DE', 'AT', 'CH'];

    public function __construct(private RegionalService $service)
    {
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [
                ['setupLocale', 25],
                ['onKernelRequest', 20],
            ],
        ];
    }

    public function setupLocale(RequestEvent $event)
    {
        $request = $event->getRequest();

        if (!$request->getSession()->has('_locale_decided')) {
            $request->getSession()->set('_locale', $this->decideLocale());
            $request->getSession()->set('_locale_decided', true);
        }
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        if (!$request->hasPreviousSession()) {
            return;
        }

        if ($locale = $request->attributes->get('_locale')) {
            $request->getSession()->set('_locale', $locale);
        } else {
            $request->setLocale($request->getSession()->get('_locale', $this->decideLocale()));
        }
    }

    private function decideLocale(): string
    {
        return $this->isGermanSpeakingCountry() ? 'de' : 'en';
    }

    private function isGermanSpeakingCountry(): bool
    {
        return in_array($this->service->getVisitorCountryCode(), self::GERMAN_SPEAKING_COUNTRY_CODES);
    }
}
