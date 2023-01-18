<?php

namespace Liondeer\Framework;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class LiondeerFrameworkBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}