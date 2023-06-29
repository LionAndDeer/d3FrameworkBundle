<?php

namespace Liondeer\Framework\D3\Model\Dms;


class DMSObject
{
    private string $filename;
    private string $sourceCategory;
    private string $sourceId;
    private string $alterationText = '';
    private string $contentLocationUri;
    private DMSSourceProperties $sourceProperties;

    public function __construct()
    {
        $this->sourceProperties = new DMSSourceProperties();
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): DMSObject
    {
        $this->filename = $filename;
        return $this;
    }

    public function getSourceCategory(): string
    {
        return $this->sourceCategory;
    }

    public function setSourceCategory(string $sourceCategory): DMSObject
    {
        $this->sourceCategory = $sourceCategory;
        return $this;
    }

    public function getSourceId(): string
    {
        return $this->sourceId;
    }

    public function setSourceId(string $sourceId): DMSObject
    {
        $this->sourceId = $sourceId;
        return $this;
    }

    public function getAlterationText(): string
    {
        return $this->alterationText;
    }

    public function setAlterationText(string $alterationText): DMSObject
    {
        $this->alterationText = $alterationText;
        return $this;
    }

    public function getContentLocationUri(): string
    {
        return $this->contentLocationUri;
    }

    public function setContentLocationUri(string $contentLocationUri): DMSObject
    {
        $this->contentLocationUri = $contentLocationUri;
        return $this;
    }

    public function getSourceProperties(): DMSSourceProperties
    {
        return $this->sourceProperties;
    }

    public function setSourceProperties(DMSSourceProperties $sourceProperties): self
    {
        $this->sourceProperties = $sourceProperties;
        return $this;
    }

    public function addProperty(string $key, array $values): DMSObject
    {
        $this->sourceProperties->addOrUpdateProperty($key, $values);

        return $this;
    }

    public function serialize(): string
    {
        return $this->getJson();
    }

    private function getJson(): string
    {
        $temporaryArray = [
            'sourceCategory' => $this->sourceCategory,
            'sourceId' => $this->sourceId,
            'sourceProperties' => [
                'properties' => $this->sourceProperties->toArray()
            ]
        ];

        if (!empty($this->filename)) {
            $fileInfoArray = [
                'alterationText' => $this->alterationText,
                'filename' => $this->filename,
                'contentLocationUri' => $this->contentLocationUri
            ];
            $temporaryArray = array_merge($temporaryArray, $fileInfoArray);
        }

        return json_encode($temporaryArray, JSON_UNESCAPED_SLASHES);
    }
}