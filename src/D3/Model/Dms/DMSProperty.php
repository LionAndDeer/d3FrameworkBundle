<?php


namespace Liondeer\Framework\D3\Model\Dms;

#[\Attribute]
class DMSProperty
{
    private string $key;
    private array $values;

    public function getKey(): string
    {
        return $this->key;
    }

    public function setKey(string $key): self
    {
        $this->key = $key;
        return $this;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function addValue(string $value): self
    {
        $this->values[] = $value;
        return $this;
    }

    public function addValues(array $values): self
    {
        $this->values = $values;
        return $this;
    }
}