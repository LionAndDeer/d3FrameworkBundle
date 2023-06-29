<?php

namespace Liondeer\Framework\Model;

class SourceModel
{
    private string $id;
    private string $displayName;

    /** @var SourceCategoryModel[] */
    private array $sourceCategoryModels;

    /** @var SourcePropertyModel[]*/
    private array $sourcePropertyModels;
    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return SourceModel
     */
    public function setId(string $id): SourceModel
    {
        $this->id = $id;
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
     * @return SourceModel
     */
    public function setDisplayName(string $displayName): SourceModel
    {
        $this->displayName = $displayName;
        return $this;
    }

    /**
     * @return array
     */
    public function getSourceCategoryModels(): array
    {
        return $this->sourceCategoryModels;
    }

    /**
     * @param SourceCategoryModel[] $sourceCategoryModels
     * @return SourceModel
     */
    public function setSourceCategoryModels(array $sourceCategoryModels): SourceModel
    {
        $this->sourceCategoryModels = $sourceCategoryModels;
        return $this;
    }

    /**
     * @return array
     */
    public function getSourcePropertyModels(): array
    {
        return $this->sourcePropertyModels;
    }

    /**
     * @param array $sourcePropertyModels
     * @return SourceModel
     */
    public function setSourcePropertyModels(array $sourcePropertyModels): SourceModel
    {
        $this->sourcePropertyModels = $sourcePropertyModels;
        return $this;
    }

    public function addSourceCategory(SourceCategoryModel $sourceCategoryModel): SourceModel
    {
                        $this->sourceCategoryModels[] = $sourceCategoryModel;
                        return $this;
    }

    public function addSourceProperty(SourcePropertyModel $sourcePropertyModel): SourceModel
    {
        $this->sourcePropertyModels[] = $sourcePropertyModel;
        return $this;
    }

        public function getConfig(): array
    {
        $categories = [];
        foreach ($this->sourceCategoryModels as $sourceCategoryModel) {
            $categories[] = $sourceCategoryModel->getConfig();
        }

        $properties = [];
        foreach ($this->sourcePropertyModels as $sourcePropertyModel) {
            $properties[] = $sourcePropertyModel->getConfig();
        }

        return [
            'id' => $this->id,
            'displayName' => $this->displayName,
            'categories' => $categories,
            'properties' => $properties
        ];
    }
}