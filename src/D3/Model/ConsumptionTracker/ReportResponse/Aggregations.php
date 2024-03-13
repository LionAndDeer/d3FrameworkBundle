<?php

namespace Liondeer\Framework\D3\Model\ConsumptionTracker\ReportResponse;

class Aggregations
{
    private int $average;
    private int $max;
    private int $min;
    private int $distinctDetails;
    private int $sum;

    public function getAverage(): int
    {
        return $this->average;
    }

    public function setAverage(int $average): void
    {
        $this->average = $average;
    }

    public function getMax(): int
    {
        return $this->max;
    }

    public function setMax(int $max): void
    {
        $this->max = $max;
    }

    public function getMin(): int
    {
        return $this->min;
    }

    public function setMin(int $min): void
    {
        $this->min = $min;
    }

    public function getDistinctDetails(): int
    {
        return $this->distinctDetails;
    }

    public function setDistinctDetails(int $distinctDetails): void
    {
        $this->distinctDetails = $distinctDetails;
    }

    public function getSum(): int
    {
        return $this->sum;
    }

    public function setSum(int $sum): void
    {
        $this->sum = $sum;
    }


}