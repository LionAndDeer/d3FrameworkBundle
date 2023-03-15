<?php

namespace Liondeer\Framework\D3\Model\SmartInvoice\V1;

class CostCenterModel
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
     * @return CostCenterModel
     */
    public function setCompanyId(?string $companyId): CostCenterModel
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
     * @return CostCenterModel
     */
    public function setNr(?string $nr): CostCenterModel
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
     * @return CostCenterModel
     */
    public function setName(?string $name): CostCenterModel
    {
        $this->name = $name;
        return $this;
    }
}