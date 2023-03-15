<?php

namespace Liondeer\Framework\D3\Model\SmartInvoice\V1;

class TaxCodeModel
{
    private ?string $companyId = null;
    private ?string $id = null;
    private ?string $name = null;
    private string $percentage = "0";

    /**
     * @return string|null
     */
    public function getCompanyId(): ?string
    {
        return $this->companyId;
    }

    /**
     * @param string|null $companyId
     * @return TaxCodeModel
     */
    public function setCompanyId(?string $companyId): TaxCodeModel
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
     * @return TaxCodeModel
     */
    public function setId(?string $id): TaxCodeModel
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return TaxCodeModel
     */
    public function setName(?string $name): TaxCodeModel
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getPercentage(): string
    {
        return $this->percentage;
    }

    /**
     * @param string|null $percentage
     * @return TaxCodeModel
     */
    public function setPercentage(?string $percentage): TaxCodeModel
    {
        if (is_null($percentage)) {
            $percentage = "0";
        }

        $this->percentage = $percentage;
        return $this;
    }
}