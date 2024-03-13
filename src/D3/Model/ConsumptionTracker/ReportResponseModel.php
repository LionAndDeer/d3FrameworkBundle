<?php

namespace Liondeer\Framework\D3\Model\ConsumptionTracker;

use Liondeer\Framework\D3\Model\ConsumptionTracker\ReportResponse\ConsumptionModel;
use Liondeer\Framework\D3\Model\ConsumptionTracker\ReportResponse\MetaModel;

class ReportResponseModel
{
    private MetaModel $meta;

    /** @var ConsumptionModel[]  */
    private array $consumption ;

    public function getMeta(): MetaModel
    {
        return $this->meta;
    }

    public function setMeta(MetaModel $meta): void
    {
        $this->meta = $meta;
    }

    public function getConsumption(): array
    {
        return $this->consumption;
    }

    public function setConsumption(array $consumption): void
    {
        $this->consumption = $consumption;
    }
}