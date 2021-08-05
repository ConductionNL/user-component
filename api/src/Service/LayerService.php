<?php

namespace App\Service;

use Conduction\CommonGroundBundle\Service\CommonGroundService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class LayerService
{
    private EntityManagerInterface $entityManager;
    private ParameterBagInterface $parameterBag;
    private CommonGroundService $commonGroundService;

    public function __construct(EntityManagerInterface $entityManager, ParameterBagInterface $parameterBag, CommonGroundService $commonGroundService)
    {
        $this->commonGroundService = $commonGroundService;
        $this->entityManager = $entityManager;
        $this->parameterBag = $parameterBag;
    }

    public function getCommonGroundService(): CommonGroundService
    {
        return $this->commonGroundService;
    }

    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    public function getParameterBag(): ParameterBagInterface
    {
        return $this->parameterBag;
    }
}
