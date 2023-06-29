<?php

namespace Liondeer\Framework\Model;

class AppModel
{
    private string $name;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    /**
     * @param string $name
     * @return AppModel
     */
    public function setName(string $name): AppModel
    {
        $this->name = $name;
        return $this;
    }
}