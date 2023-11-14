<?php


namespace Liondeer\Framework\Controller;


use Liondeer\Framework\Model\FeatureModel;

interface AbstractFeatureControllerInterface
{
    public function defineFeature();

    public function getFeatureModel(): ?FeatureModel;
}