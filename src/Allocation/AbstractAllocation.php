<?php


namespace Liondeer\Framework\Allocation;


use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;

abstract class AbstractAllocation
{
    public static function getAllocationValues(): array
    {
        $reflection = new \ReflectionClass(get_called_class());
        $constantValues = array_flip($reflection->getConstants());
        $className = $reflection->getShortName();

        foreach ($constantValues as &$constantValue) {
            $constantValue = self::formatTranslationKey($className, $constantValue);
        }

        return $constantValues;
    }

    private static function formatTranslationKey($className, $constantValue): string
    {
        $nameConverter = new CamelCaseToSnakeCaseNameConverter();
        $className = $nameConverter->normalize($className);

        return $className . '.' . strtolower($constantValue);
    }

    public static function getAllocationTranslationKey($constName): string
    {
        $reflection = new \ReflectionClass(get_called_class());
        $constantValue = $reflection->getConstant($constName);
        $className = $reflection->getName();

        return strtolower($className) . '.' . strtolower($constantValue);
    }

}