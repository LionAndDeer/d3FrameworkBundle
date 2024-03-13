<?php

namespace Liondeer\Framework\D3\Model\ConsumptionTracker;

class ReportRequestModel
{

    private string $startDate;
    private string $period;
    private string $tenant;
    private string $app;

    public function getStartDate(): string
    {
        return $this->startDate;
    }

    public function setStartDate(string $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getPeriod(): string
    {
        return $this->period;
    }

    public function setPeriod(string $period): void
    {
        $this->period = $period;
    }

    public function getTenant(): string
    {
        return $this->tenant;
    }

    public function setTenant(string $tenant): void
    {
        $this->tenant = $tenant;
    }

    public function getApp(): string
    {
        return $this->app;
    }

    public function setApp(string $app): void
    {
        $this->app = $app;
    }


}