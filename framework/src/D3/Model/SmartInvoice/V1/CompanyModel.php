<?php

namespace Liondeer\Framework\D3\Model\SmartInvoice\V1;

class CompanyModel
{
    private ?string $id = null;
    private ?string $nr = null;
    private ?string $name = null;
    private ?string $parentId = null;
    private ?string $address = null;
    private ?string $city = null;
    private ?string $zipCode = null;

    /**
     * @return string|null
     */
    public function getNr(): ?string
    {
        return $this->nr;
    }

    /**
     * @param string|null $nr
     * @return CompanyModel
     */
    public function setNr(?string $nr): CompanyModel
    {
        $this->nr = $nr;
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
     * @return CompanyModel
     */
    public function setId(?string $id): CompanyModel
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
     * @return CompanyModel
     */
    public function setName(?string $name): CompanyModel
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getParentId(): ?string
    {
        return $this->parentId;
    }

    /**
     * @param string|null $parentId
     * @return CompanyModel
     */
    public function setParentId(?string $parentId): CompanyModel
    {
        $this->parentId = $parentId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     * @return CompanyModel
     */
    public function setAddress(?string $address): CompanyModel
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     * @return CompanyModel
     */
    public function setCity(?string $city): CompanyModel
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    /**
     * @param string|null $zipCode
     * @return CompanyModel
     */
    public function setZipCode(?string $zipCode): CompanyModel
    {
        $this->zipCode = $zipCode;
        return $this;
    }

}
