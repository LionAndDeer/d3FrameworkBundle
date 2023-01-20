<?php


namespace Liondeer\Framework\Lifecycle;


interface LifecycleEventInterface
{
    public function processEvent(array $parameters);
}