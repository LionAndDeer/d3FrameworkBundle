<?php

namespace Liondeer\Framework\Controller;

use Liondeer\Framework\Model\ConfigFeatureModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class AbstractConfigFeatureController
    extends AbstractController
    implements AbstractConfigFeatureControllerInterface
{
    protected ConfigFeatureModel $configFeatureModel;
    protected TranslatorInterface $translator;

    /**
     * @return ?ConfigFeatureModel
     */
    public function getConfigFeatureModel(): ?ConfigFeatureModel
    {
        $this->defineConfigFeature();
        return empty($this->configFeatureModel) ? null : $this->configFeatureModel;
    }

    /**
     * @param int $order Muss innerhalb einer Headline unique sein
     * @return ConfigFeatureModel
     */
    protected function generateConfigFeatureModel(int $order): ConfigFeatureModel
    {
        $this->configFeatureModel = new ConfigFeatureModel($this->translator, $order);
        return $this->configFeatureModel;
    }
}