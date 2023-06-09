<?php

namespace Liondeer\Framework\D3\Manager\Dms;

use Liondeer\Framework\D3\Model\Dms\DMSProperty;
use Liondeer\Framework\D3\Model\Dms\DMSSourceProperties;
use Liondeer\Framework\Model\SourcePropertyModel;
use function PHPUnit\Framework\isInstanceOf;

class SourceManager
{
    /** @return  SourcePropertyModel[] */
    public function getSourcePropertyModels(array $annotatedModels, array $categories): array
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
                        /** @var SourcePropertyModel $sourceProperty */
                        $sourceProperty = $attribute->newInstance();
                        if (!empty(array_intersect($sourceProperty->getCategories(), $categories))) {
                            $sourceProperties[$sourceProperty->getKey()] = $sourceProperty;
                        }
                    }

                }
            }
        }

        return $sourceProperties;
    }

    /** @return DMSSourceProperties */
    public function getDmsSourceProperties(array $objects, array $categories): DMSSourceProperties
    {
        $dmsSourceProperties = new DMSSourceProperties();

        foreach ($objects as $object) {
            $reflection = new \ReflectionObject($object);
            $classProperties = $reflection->getProperties();
            foreach ($classProperties as $property) {
                $attributes = $property->getAttributes();
                foreach ($attributes as $attribute) {
                    $attributeName = $attribute->getName();
                    if ($attributeName == SourcePropertyModel::class) {
                        /** @var SourcePropertyModel $sourceProperty */
                        $sourceProperty = $attribute->newInstance();
                        if (!empty(array_intersect($sourceProperty->getCategories(), $categories))) {
                            if (!empty($property->getValue($object))) {
                                $value = $property->getValue($object);
                                if ($value instanceof \DateTime){
                                    /** @var \DateTime $value */
                                    $value = $value->format('c');
                                }
                                $dmsSourceProperties->addOrUpdateProperty($sourceProperty->getKey(), [$value]);
                            }
                        }
                    }

                }
            }
        }

        return $dmsSourceProperties;
    }
}