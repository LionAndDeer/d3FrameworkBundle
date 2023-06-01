<?php

namespace Liondeer\Framework\Controller;

use Liondeer\Framework\Model\SourceModel;

interface AbstractSourceControllerInterface
{
    public function defineSource();
    public function getSourceModel(): SourceModel;
}