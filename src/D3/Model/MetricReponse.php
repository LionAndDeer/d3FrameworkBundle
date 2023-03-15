<?php

namespace Liondeer\Framework\D3\Model;

class MetricReponse
{
    /** @var Metric[]|null $consumed */
    private ?array $consumed;

    /** @var Metric[]|null $rejected */
    private ?array $rejected;

    public function getConsumed(): ?array
    {
        return $this->consumed;
    }

    public function setConsumed(?array $consumed): void
    {
        $this->consumed = $consumed;
    }

    public function getRejected(): ?array
    {
        return $this->rejected;
    }

    public function setRejected(?array $rejected): void
    {
        $this->rejected = $rejected;
    }
}