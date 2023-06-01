<?php

namespace Liondeer\Framework\D3\Manager\Dms;

use Liondeer\Framework\Model\SourcePropertyModel;

class SourceManager
{
    /** @return  SourcePropertyModel[] */
    public function getSourcePropertyModels(array $annotatedModels): array
    {
        $sourceProperties = [];

        foreach ($annotatedModels as $annotatedModel) {
            $reflection = new \ReflectionClass($annotatedModel);
            $classProperties = $reflection->getProperties();
            foreach ($classProperties as $property) {
                $attributes = $property->getAttributes();
                foreach ($attributes as $attribute) {
                    $attributeName = $attribute->getName();
                    if ($attributeName == SourcePropertyModel::class) {
                        $arguments = $attribute->getArguments();
                        $sourceProperty = new SourcePropertyModel($arguments['key'],$arguments['displayName']);
                        $sourceProperties[$property->getName()] = $sourceProperty;
                    }

                }
            }
        }

        return $sourceProperties;
    }

}