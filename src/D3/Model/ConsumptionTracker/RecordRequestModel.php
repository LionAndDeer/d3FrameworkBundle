<?php

namespace Liondeer\Framework\D3\Model\ConsumptionTracker;

use DateTime;
use DateTimeInterface;
use Liondeer\Framework\Exception\LiondeerD3FrameworkException;

class RecordRequestModel
{
    private string $metric;
    private int $quantity;
    private ?string $detail;
    private \DateTime $timeOfPerformance;
    private string $billedAggregation;

    public function __construct(string $metricName)
    {
        $this->metric = $metricName;
        $this->quantity = 1;
        $this->timeOfPerformance = new DateTime('now');
        $this->billedAggregation = 'sum';
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(?string $detail): void
    {
        $this->detail = $detail;
    }

    public function getTimeOfPerformance(): string
    {
        $timeOfPerformance = $this->timeOfPerformance;
        $timeOfPerformance->setTimezone(new \DateTimeZone('UTC'));
        return $timeOfPerformance->format(DateTimeInterface::RFC3339);
    }

    public function setTimeOfPerformance(\DateTime $timeOfPerformance): void
    {
        $this->timeOfPerformance = $timeOfPerformance;
    }

    public function getBilledAggregation(): string
    {
        return $this->billedAggregation;
    }

    public function setBilledAggregation(string $billedAggregation): void
    {
        $allowedAggregations = [
          'avg',
          'sum',
          'min',
          'max',
          'countDistinctDetails'
        ];

        if(!in_array(strtolower($billedAggregation), $allowedAggregations)) {
            throw new LiondeerD3FrameworkException('Consumptiontracker - billedAggregation "'.$billedAggregation.'" is not allowed');
        }
        
        $this->billedAggregation = $billedAggregation;
    }

    public function isValid(): bool
    {
        if (
            $this->billedAggregation === 'countDistinctDetails' &&
            empty($this->detail)
        ) {
            throw new LiondeerD3FrameworkException('Consumptiontracker - detail is necessary when using billedAggregation "countDistinctDetails"');
        }

        return true;
    }
}