<?php
namespace Liondeer\Framework;

use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class LiondeerFrameworkBundle extends AbstractBundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}