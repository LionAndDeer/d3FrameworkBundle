<?php

namespace Liondeer\Framework\D3\Model\SmartInvoice\V1\Webhook;

class StepModel
{
    private ?string $id = null;
    private ?string $title = null;
    private ?string $localized_title = null;

    public function getLocalizedTitle(): ?string
    {
        return $this->localized_title;
    }

    public function setLocalizedTitle(?string $localized_title): StepModel
    {
        $this->localized_title = $localized_title;
        return $this;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): StepModel
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): StepModel
    {
        $this->title = $title;
        return $this;
    }
}