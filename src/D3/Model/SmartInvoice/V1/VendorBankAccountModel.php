<?php

namespace Liondeer\Framework\D3\Model\SmartInvoice\V1;

class VendorBankAccountModel
{
    private ?string $companyId = null;
    private string $vendor_id = '';
    private string $iban = '';
    private ?string $bic = null;
    private ?bool $primary = null;

    /**
     * @return string|null
     */
    public function getCompanyId(): ?string
    {
        return $this->companyId;
    }

    /**
     * @param string|null $companyId
     * @return VendorBankAccountModel
     */
    public function setCompanyId(?string $companyId): VendorBankAccountModel
    {
        $this->companyId = $companyId;
        return $this;
    }

    /**
     * @return string
     */
    public function getVendorId(): string
    {
        return $this->vendor_id;
    }

    /**
     * @param string $vendor_id
     * @return VendorBankAccountModel
     */
    public function setVendorId(string $vendor_id): VendorBankAccountModel
    {
        $this->vendor_id = $vendor_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getIban(): string
    {
        return $this->iban;
    }

    /**
     * @param string $iban
     * @return VendorBankAccountModel
     */
    public function setIban(string $iban): VendorBankAccountModel
    {
        $this->iban = $iban;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBic(): ?string
    {
        return $this->bic;
    }

    /**
     * @param string|null $bic
     * @return VendorBankAccountModel
     */
    public function setBic(?string $bic): VendorBankAccountModel
    {
        $this->bic = $bic;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getPrimary(): ?bool
    {
        return $this->primary;
    }

    /**
     * @param bool|null $primary
     * @return VendorBankAccountModel
     */
    public function setPrimary(?bool $primary): VendorBankAccountModel
    {
        $this->primary = $primary;
        return $this;
    }

}