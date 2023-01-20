<?php

namespace Liondeer\Framework\D3\Model\SmartInvoice\V1;

class VendorModel
{
    private ?string $companyId = null;
    private string $id = '';
    private ?string $nr = null;
    private string $name = '';
    private string $address = '';
    private string $city = '';
    private string $zipCode = '';
    private string $country = '';
    private string $eMail = '';
    private ?string $vatId = null;

    /**
     * @return string|null
     */
    public function getNr(): ?string
    {
        return $this->nr;
    }

    /**
     * @param string|null $nr
     * @return VendorModel
     */
    public function setNr(?string $nr): VendorModel
    {
        $this->nr = $nr;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCompanyId(): ?string
    {
        return $this->companyId;
    }

    /**
     * @param string|null $companyId
     * @return VendorModel
     */
    public function setCompanyId(?string $companyId): VendorModel
    {
        $this->companyId = $companyId;
        return $this;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return VendorModel
     */
    public function setId(string $id): VendorModel
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return VendorModel
     */
    public function setName(string $name): VendorModel
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return VendorModel
     */
    public function setAddress(string $address): VendorModel
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return VendorModel
     */
    public function setCity(string $city): VendorModel
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     * @return VendorModel
     */
    public function setZipCode(string $zipCode): VendorModel
    {
        $this->zipCode = $zipCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return VendorModel
     */
    public function setCountry(string $country): VendorModel
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return string
     */
    public function getEMail(): string
    {
        return $this->eMail;
    }

    /**
     * @param string $eMail
     * @return VendorModel
     */
    public function setEMail(string $eMail): VendorModel
    {
        $this->eMail = $eMail;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getVatId(): ?string
    {
        return $this->vatId;
    }

    /**
     * @param string|null $vatId
     * @return VendorModel
     */
    public function setVatId(?string $vatId): VendorModel
    {
        $this->vatId = $vatId;
        return $this;
    }
}