<?php


namespace Liondeer\Framework\Controller;


use Liondeer\Framework\Model\ConfigFeatureModel;

interface AbstractConfigFeatureControllerInterface
{
    public function defineConfigFeature();

    public function getConfigFeatureModel(): ConfigFeatureModel;
}