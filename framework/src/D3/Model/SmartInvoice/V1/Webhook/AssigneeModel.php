<?php

namespace Liondeer\Framework\D3\Model\SmartInvoice\V1\Webhook;

class AssigneeModel
{
    private ?string $type = null;
    private ?int $id = null;
    private ?string $name = null;
    private ?string $displayName = null;
    private ?int $delegate_id = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return AssigneeModel
     */
    public function setId(?int $id): AssigneeModel
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getDelegateId(): ?int
    {
        return $this->delegate_id;
    }

    /**
     * @param int|null $delegate_id
     * @return AssigneeModel
     */
    public function setDelegateId(?int $delegate_id): AssigneeModel
    {
        $this->delegate_id = $delegate_id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return AssigneeModel
     */
    public function setType(?string $type): AssigneeModel
    {
        $this->type = $type;
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
     * @return AssigneeModel
     */
    public function setName(?string $name): AssigneeModel
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    /**
     * @param string|null $displayName
     * @return AssigneeModel
     */
    public function setDisplayName(?string $displayName): AssigneeModel
    {
        $this->displayName = $displayName;
        return $this;
    }
}