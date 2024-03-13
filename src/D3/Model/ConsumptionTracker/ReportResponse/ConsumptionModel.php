<?php

namespace Liondeer\Framework\D3\Model\ConsumptionTracker\ReportResponse;

class ConsumptionModel
{
    private string $appId;
    private string $tenantId;
    private string $metric;
    private Aggregations $aggregations;
    private string $billedAggregation;
    private int $billedValue;

    public function getAppId(): string
    {
        return $this->appId;
    }

    public function setAppId(string $appId): void
    {
        $this->appId = $appId;
    }

    public function getTenantId(): string
    {
        return $this->tenantId;
    }

    public function setTenantId(string $tenantId): void
    {
        $this->tenantId = $tenantId;
    }

    public function getMetric(): string
    {
        return $this->metric;
    }

    public function setMetric(string $metric): void
    {
        $this->metric = $metric;
    }

    public function getAggregations(): Aggregations
    {
        return $this->aggregations;
    }

    public function setAggregations(Aggregations $aggregations): void
    {
        $this->aggregations = $aggregations;
    }

    public function getBilledAggregation(): string
    {
        return $this->billedAggregation;
    }

    public function setBilledAggregation(string $billedAggregation): void
    {
        $this->billedAggregation = $billedAggregation;
    }

    public function getBilledValue(): int
    {
        return $this->billedValue;
    }

    public function setBilledValue(int $billedValue): void
    {
        $this->billedValue = $billedValue;
    }


}