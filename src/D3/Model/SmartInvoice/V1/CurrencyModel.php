<?php

namespace Liondeer\Framework\D3\Model\SmartInvoice\V1;

class CurrencyModel
{
    private ?string $companyId = null;
    private ?string $id = null;
    private ?string $name = null;
    private ?string $code = null;

    /**
     * @return string|null
     */
    public function getCompanyId(): ?string
    {
        return $this->companyId;
    }

    /**
     * @param string|null $companyId
     * @return CurrencyModel
     */
    public function setCompanyId(?string $companyId): CurrencyModel
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
     * @return CurrencyModel
     */
    public function setId(?string $id): CurrencyModel
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
     * @return CurrencyModel
     */
    public function setName(?string $name): CurrencyModel
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string|null $code
     * @return CurrencyModel
     */
    public function setCode(?string $code): CurrencyModel
    {
        $this->code = $code;
        return $this;
    }
}