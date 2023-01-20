<?php

namespace Liondeer\Framework\Controller;

use Liondeer\Framework\Model\FeatureModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class AbstractFeatureController
    extends AbstractController
    implements AbstractFeatureControllerInterface
{
    protected FeatureModel $featureModel;

    public function __construct(
        private TranslatorInterface $translator
    ) {
    }

    public function getFeatureModel(): FeatureModel
    {
        $this->defineFeature();

        return $this->featureModel;
    }


    protected function generateFeatureModel(): FeatureModel
    {
        $this->featureModel = new FeatureModel($this->translator);

        return $this->featureModel;
    }
}