<?php

namespace Liondeer\Framework\Controller;

use Liondeer\Framework\D3\Manager\Dms\SourceManager;
use Liondeer\Framework\Model\SourceModel;
use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class AbstractSourceController
    extends  AbstractController
    implements AbstractSourceControllerInterface
{
    protected   SourceModel $sourceModel;
    protected   array $annotatedModels;
    protected SourceManager $sourceManager;

    public function __construct(
        SourceManager $sourceManager
    ) {
        $this->sourceManager = $sourceManager;
    }

    public function getSourceModel(): SourceModel
    {
        $this->defineSource();
        $sourceModel = $this->sourceModel;

        $sourceModel->setSourcePropertyModels($this->sourceManager->getSourcePropertyModels($this->annotatedModels));
        return $sourceModel;
    }
}