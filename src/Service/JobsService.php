<?php

namespace App\Service;

use App\Entity\Vacancy;
use App\Repository\VacancyRepository;
use Doctrine\Common\Collections\Collection;

class JobsService
{
    public function __construct(
        private VacancyRepository $vacancyRepository,
        private RegionalService $regionalService,
    ) {
    }

    /**
     * @return Collection|Vacancy[]
     */
    public function getJobsByCountry(): Collection|array
    {
        $visitorCountryCode = $this->regionalService->getVisitorCountryCode();

        return $this->vacancyRepository->findBy([
            'open' => true,
            'countryCode' => $visitorCountryCode,
        ]);
    }
}
