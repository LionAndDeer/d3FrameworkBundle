<?php

namespace Liondeer\Framework\D3\Model\SmartInvoice\V1;

class GlAccountModel
{
    private ?string $companyId = null;
    private ?string $nr = '';
    private ?string $name = '';

    public function getCompanyId(): ?string
    {
        return $this->companyId;
    }


    public function setCompanyId(?string $companyId): GlAccountModel
    {
        $this->companyId = $companyId;
        return $this;
    }

    public function getNr(): ?string
    {
        return $this->nr;
    }

    public function setNr(?string $nr): GlAccountModel
    {
        $this->nr = $nr;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): GlAccountModel
    {
        $this->name = $name;
        return $this;
    }
}