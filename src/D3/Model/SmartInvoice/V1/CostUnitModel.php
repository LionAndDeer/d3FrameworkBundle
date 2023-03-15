<?php

namespace Liondeer\Framework\D3\Model\SmartInvoice\V1;

class CostUnitModel
{
    private ?string $companyId = null;
    private ?string $nr = null;
    private ?string $name = null;

    /**
     * @return string|null
     */
    public function getCompanyId(): ?string
    {
        return $this->companyId;
    }

    /**
     * @param string|null $companyId
     * @return CostUnitModel
     */
    public function setCompanyId(?string $companyId): CostUnitModel
    {
        $this->companyId = $companyId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNr(): ?string
    {
        return $this->nr;
    }

    /**
     * @param string|null $nr
     * @return CostUnitModel
     */
    public function setNr(?string $nr): CostUnitModel
    {
        $this->nr = $nr;
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
     * @return CostUnitModel
     */
    public function setName(?string $name): CostUnitModel
    {
        $this->name = $name;
        return $this;
    }
}