<?php

namespace Liondeer\Framework\D3\Model\SmartInvoice\V1\Webhook;

class QuantityModel
{
    private ?string $invoiced = null;

    /**
     * @return string|null
     */
    public function getInvoiced(): ?string
    {
        return $this->invoiced;
    }

    /**
     * @param string|null $invoiced
     * @return QuantityModel
     */
    public function setInvoiced(?string $invoiced): QuantityModel
    {
        $this->invoiced = $invoiced;
        return $this;
    }
}