<?php

namespace Sokil\StaticMenuBundle;

use Knp\Menu\FactoryInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class Builder
 * @package Sokil\SiteCoreBundle\Menu
 */
class StaticMenuBuilder
{
    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    /**
     * @param FactoryInterface $factory
     * @param TranslatorInterface $translator,
     * @param AuthorizationCheckerInterface $authorizationChecker,
     */
    public function __construct(
        FactoryInterface $factory,
        TranslatorInterface $translator,
        AuthorizationCheckerInterface $authorizationChecker
    ) {
        $this->factory = $factory;
        $this->translator = $translator;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @param string $menuName
     * @return \Knp\Menu\ItemInterface
     * @throws \Exception
     */
    public function build(array $configuration)
    {
        // init root
        $rootItem = $this->factory->createItem('root', $configuration);

        // init items
        // see item options at vendor/knplabs/knp-menu/src/Knp/Menu/Factory/CoreExtension.php
        foreach ($configuration['items'] as $name => $item) {
            // check role
            if (isset($item['role']) && !$this->authorizationChecker->isGranted($item['role'])) {
                continue;
            }

            // add item
            $item['label'] = $this->translator->trans($item['label']);
            $rootItem->addChild($name, $item);
        }

        return $rootItem;
    }
}