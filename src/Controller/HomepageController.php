<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Form\JobApplicationType;
use App\Helper\EmployeeReviewHelper;
use App\Helper\PortfolioHelper;
use App\Service\CaptchaService;
use App\Service\JobsService;
use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route(
        path: '/',
        name: 'home'
    )]
    public function index(Request $request): Response
    {
        $secondLang = 'de';

        if ($secondLang === $request->getSession()->get('_locale') && !str_contains($request->getPathInfo(), '/'.$secondLang)) {
            return $this->redirect($this->generateUrl('home', ['_locale' => $secondLang]));
        }

        return $this->render('homepage/index.html.twig', [
            'portfolioData' => PortfolioHelper::getPortfolioData(),
        ]);
    }

    #[Route(
        path: [
            'en' => '/career',
            'de' => '/karriere',
        ],
        name: 'career'
    )]
    public function career(Request $request, JobsService $jobsService, MailerService $mailer, CaptchaService $captchaService): Response
    {
        $vacancies = $jobsService->getJobsByCountry();
        $form = $this->createForm(JobApplicationType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $captchaService->captchaVerify($request->get('g-recaptcha-response'))) {
            $mailer->sendCareerEmail($form->getData());

            return $this->redirectToRoute('thank_you');
        }

        return $this->render('homepage/career.html.twig', [
            'vacancies' => $vacancies,
            'reviewInterval' => 3500,
            'reviews' => EmployeeReviewHelper::getEmployeeReviewData(),
            'form' => $form->createView(),
        ]);
    }

    #[Route(
        path: [
            'en' => '/contact',
            'de' => '/kontakt',
        ],
        name: 'contact'
    )]
    public function contact(Request $request, MailerService $mailer, CaptchaService $captchaService): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $captchaService->captchaVerify($request->get('g-recaptcha-response'))) {
            $mailer->sendContactEmail($form->getData());

            return $this->redirectToRoute('thank_you');
        }

        return $this->render('homepage/contact.html.twig', [
            'controller_name' => 'HomepageController',
            'mapsKey' => $this->getParameter('google.maps.key'),
            'form' => $form->createView(),
        ]);
    }

    #[Route(
        path: [
            'en' => '/thank-you',
            'de' => '/danke',
        ],
        name: 'thank_you'
    )]
    public function thankYou(): Response
    {
        return $this->render('homepage/thank-you.html.twig');
    }

    #[Route(
        path: '/lang/switch/{locale}',
        name: 'switch-lang',
        requirements: ['locale' => 'en|de']
    )]
    public function changeLocale(Request $request, string $locale): Response
    {
        $request->getSession()->set('_locale', $locale);

        return $this->redirect($this->generateUrl($this->getReferer($request), ['_locale' => $locale]));
    }

    private function getReferer(Request $request): string
    {
        $router = $this->get('router');
        $referer = parse_url($request->headers->get('referer'));
        $route = $router->match($referer['path']);

        return $route['_route'];
    }
}
