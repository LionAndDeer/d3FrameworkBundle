<?php


namespace Liondeer\Framework\Controller;


interface AbstractDmsObjectExtensionControllerInterface
{
    public function defineExtension();

    public function getExtensionModel();
}