<?php

namespace Liondeer\Framework\Model;

#[\Attribute]
class SourcePropertyModel
{
    public function __construct(
        private string $key,
        private string $displayName
    )
    {

    }


    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     * @return SourcePropertyModel
     */
    public function setKey(string $key): SourcePropertyModel
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    /**
     * @param string $displayName
     * @return SourcePropertyModel
     */
    public function setDisplayName(string $displayName): SourcePropertyModel
    {
        $this->displayName = $displayName;
        return $this;
    }

    public function getConfig(): array
    {
        return [
            'key' => $this->key,
            'displayName' => $this->displayName
        ];
    }

}