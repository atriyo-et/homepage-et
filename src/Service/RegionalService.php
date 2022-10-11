<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\RequestStack;

class RegionalService
{
    public function __construct(private RequestStack $requestStack)
    {
    }

    public function getVisitorCountryCode(): ?string
    {
        return $this->getVisitorGeoInfo()['country_code'] ?? '';
    }

    public function getVisitorGeoInfo(): ?array
    {
        $client = HttpClient::create();
        $ip = $this->getVisitorIp();
        $request = $client->request('GET', 'https://www.iplocate.io/api/lookup/'.$ip);

        return json_decode($request->getContent(), true);
    }

    private function getVisitorIp(): string
    {
        return $this->requestStack->getCurrentRequest()->getClientIp();
    }
}
