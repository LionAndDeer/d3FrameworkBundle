<?php

namespace Liondeer\Framework\D3\Model\SmartInvoice\V1;

class DocumentTypeModel
{
    private ?string $companyId = null;
    private ?string $id = null;
    private ?string $name = null;
    private ?bool $creditNote = null;

    /**
     * @return string|null
     */
    public function getCompanyId(): ?string
    {
        return $this->companyId;
    }

    /**
     * @param string|null $companyId
     * @return DocumentTypeModel
     */
    public function setCompanyId(?string $companyId): DocumentTypeModel
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
     * @return DocumentTypeModel
     */
    public function setId(?string $id): DocumentTypeModel
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
     * @return DocumentTypeModel
     */
    public function setName(?string $name): DocumentTypeModel
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getCreditNote(): ?bool
    {
        return $this->creditNote;
    }

    /**
     * @param bool|null $creditNote
     * @return DocumentTypeModel
     */
    public function setCreditNote(?bool $creditNote): DocumentTypeModel
    {
        $this->creditNote = $creditNote;
        return $this;
    }
}