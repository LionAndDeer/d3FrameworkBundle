<?php

namespace Liondeer\Framework\Controller;

use Liondeer\Framework\D3\Manager\Dms\SourceManager;
use Liondeer\Framework\Model\SourceModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class AbstractSourceController
    extends AbstractController
    implements AbstractSourceControllerInterface
{
    /* @var SourceModel[] $sourceModels */
    protected array $sourceModels = [];
    protected array $annotatedModels;
    protected SourceManager $sourceManager;

    public function __construct(
        SourceManager $sourceManager
    )
    {
        $this->sourceManager = $sourceManager;
    }

    /** @return SourceModel[] */
    public function getSourceModels(): array
    {
        $this->defineSource();

        $sourceModels = [];
        foreach ($this->sourceModels as $sourceModel) {
            $categories = [];
            foreach ($sourceModel->getSourceCategoryModels() as $sourceCategoryModel) {
                $categories[] = $sourceCategoryModel->getKey();
            }

            $sourceModel->setSourcePropertyModels($this->sourceManager->getSourcePropertyModels($this->annotatedModels, $categories));

            $sourceModels[] = $sourceModel;
        }
        return $sourceModels;
    }
}