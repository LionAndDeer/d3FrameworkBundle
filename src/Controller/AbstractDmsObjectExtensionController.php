<?php

namespace Liondeer\Framework\Controller;

use Liondeer\Framework\Model\DmsExtensionModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class AbstractDmsObjectExtensionController
    extends AbstractController
    implements AbstractDmsObjectExtensionControllerInterface
{
    protected DmsExtensionModel $extensionModel;

    public function __construct(private TranslatorInterface $translator) { }

    public function getExtensionModel(): DmsExtensionModel
    {
        $this->defineExtension();
        return $this->extensionModel;
    }

    protected function generateExtensionModel(): DmsExtensionModel
    {
        $this->extensionModel = new DmsExtensionModel($this->translator);
        return $this->extensionModel;
    }
}