<?php

namespace Liondeer\Framework\D3\Model\SmartInvoice\V1;

class PaymentTermsModel
{
    private ?string $companyId = null;
    private ?string $id = null;
    private string $netDays = "0";
    private int $cashbackDays1 = 0;
    private string $cashbackPercentage1 = "0";

    /**
     * @return string|null
     */
    public function getCompanyId(): ?string
    {
        return $this->companyId;
    }

    /**
     * @param string|null $companyId
     * @return PaymentTermsModel
     */
    public function setCompanyId(?string $companyId): PaymentTermsModel
    {
        $this->companyId = $companyId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     * @return PaymentTermsModel
     */
    public function setId(?string $id): PaymentTermsModel
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|int
     */
    public function getNetDays(): string|int
    {
        return $this->netDays;
    }

    /**
     * @param null|string|int $netDays
     * @return PaymentTermsModel
     */
    public function setNetDays(null|string|int $netDays): PaymentTermsModel
    {
        if (null == $netDays) {
            $netDays = "0";
        }
        $this->netDays = $netDays;
        return $this;
    }

    /**
     * @return int
     */
    public function getCashbackDays1(): int
    {
        return $this->cashbackDays1;
    }

    /**
     * @param ?int $cashbackDays1
     * @return PaymentTermsModel
     */
    public function setCashbackDays1(?int $cashbackDays1): PaymentTermsModel
    {
        if (null == $cashbackDays1) {
            $cashbackDays1 = 0;
        }
        $this->cashbackDays1 = $cashbackDays1;
        return $this;
    }

    /**
     * @return string|int
     */
    public function getCashbackPercentage1(): string|int
    {
        return $this->cashbackPercentage1;
    }

    /**
     * @param null|string|int $cashbackPercentage1
     * @return PaymentTermsModel
     */
    public function setCashbackPercentage1(null|string|int $cashbackPercentage1): PaymentTermsModel
    {
        if (null == $cashbackPercentage1) {
            $cashbackPercentage1 = "0";
        }
        $this->cashbackPercentage1 = $cashbackPercentage1;
        return $this;
    }

}