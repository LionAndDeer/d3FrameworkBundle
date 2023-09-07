<?php

namespace Liondeer\Framework\D3\Model\Dms;

use Doctrine\Common\Collections\ArrayCollection;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Serializer\Annotation\Ignore;

class DMSSourceProperties
{
    /**
     * @Ignore
     */
    private ArrayCollection $properties;

    #[Pure]
    public function __construct()
    {
        $this->properties = new ArrayCollection();
    }

    public function addOrUpdateProperty(string $key, array $values): self
    {
        $prevValues = $this->properties->get($key) ? $this->properties->get($key)->getValues() : [];
        $prop = new DMSProperty();
        $prop
            ->setKey($key)
            ->addValues([...$values, ...$prevValues]);

        $this->properties->set($key, $prop);
        return $this;
    }

    public function containsKey(string $key): bool
    {
        return $this->properties->containsKey($key);
    }

    #[Pure]
    public function toArray(): array
    {
        $propertyArray = [];
        /** @var DMSProperty $property */
        foreach ($this->properties as $property) {
            $propertyArray[] = ['key' => $property->getKey(), 'values' => $property->getValues()];
        }
        return $propertyArray;
    }
}