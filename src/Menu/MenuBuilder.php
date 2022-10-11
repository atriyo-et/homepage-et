<?php

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class MenuBuilder
{
    public function __construct(private FactoryInterface $factory)
    {
    }

    public function createMainMenu(array $options): ItemInterface
    {
        $fixedClasses = [
            'attributes' => [
                'class' => 'nav-item',
            ],
            'linkAttributes' => [
                'class' => 'nav-link p-3',
            ],
        ];

        $menu = $this->factory->createItem('root', [
            'childrenAttributes' => [
                'class' => 'navbar-nav ms-auto mb-2 mb-lg-0',
            ],
        ]);
        $menu->addChild('home', array_merge(['route' => 'home'], $fixedClasses))
            ->setAttribute('id', 'nav-home')
            ->setExtra('translation_domain', 'menu');
        $menu->addChild('about', array_merge($this->getFragmentedRoute('about'), $fixedClasses))
            ->setAttribute('id', 'nav-about')
            ->setExtra('translation_domain', 'menu');
        $menu->addChild('services', array_merge($this->getFragmentedRoute('services'), $fixedClasses))
            ->setAttribute('id', 'nav-services')
            ->setExtra('translation_domain', 'menu');
        $menu->addChild('portfolio', array_merge($this->getFragmentedRoute('portfolio'), $fixedClasses))
            ->setAttribute('id', 'nav-portfolio')
            ->setExtra('translation_domain', 'menu');
        $menu->addChild('career', array_merge(['route' => 'career'], $fixedClasses))
            ->setAttribute('id', 'nav-career')
            ->setExtra('translation_domain', 'menu');
        $menu->addChild('contact', array_merge(['route' => 'contact'], $fixedClasses))
            ->setAttribute('id', 'nav-contact')
            ->setExtra('translation_domain', 'menu');

        return $menu;
    }

    private function getFragmentedRoute($fragment): array
    {
        return ['route' => 'home', 'routeParameters' => ['_fragment' => $fragment]];
    }
}
