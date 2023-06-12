<?php

namespace Liondeer\Framework\Model;


class SourceCategoryModel
{
    private string $key;
    private string $displayName;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     * @return SourceCategoryModel
     */
    public function setKey(string $key): SourceCategoryModel
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
     * @return SourceCategoryModel
     */
    public function setDisplayName(string $displayName): SourceCategoryModel
    {
        $this->displayName = $displayName;
        return $this;
    }

    public function getConfig(): array
    {
        return  [
                        'key'  => $this->key,
            'displayName'  => $this->displayName
        ];
    }

}