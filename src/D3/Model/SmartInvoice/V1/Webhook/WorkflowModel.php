<?php

namespace Liondeer\Framework\D3\Model\SmartInvoice\V1\Webhook;

use function PHPUnit\Framework\isEmpty;

class WorkflowModel
{
    private ?int $id = null;
    private ?VoucherModel $voucher = null;
    private ?StepModel $step = null;
    private ?\DateTime $received_at = null;
    private ?bool $locked = null;
    private ConnectionModel|null $connection = null;

    /** @var AssigneeModel[]|null $assignees */
    private ?array $assignees = null;

    public function isValid(): bool
    {
        if (empty($this->voucher)) {
            return false;
        } else {
            return $this->voucher->isValid();
        }
    }

    /**
     * @return ConnectionModel|null
     */
    public function getConnection(): ?ConnectionModel
    {
        return $this->connection;
    }

    /**
     * @param ConnectionModel|null $connection
     * @return WorkflowModel
     */
    public function setConnection(?ConnectionModel $connection): WorkflowModel
    {
        $this->connection = $connection;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return WorkflowModel
     */
    public function setId(?int $id): WorkflowModel
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getReceivedAt(): ?\DateTime
    {
        return $this->received_at;
    }

    /**
     * @param \DateTime|string|null $received_at
     * @return WorkflowModel
     */
    public function setReceivedAt(\DateTime|string|null $received_at): WorkflowModel
    {
        if (is_string($received_at)) {
            $this->received_at = new \DateTime($received_at);
        } else {
            $this->received_at = $received_at;
        }
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getLocked(): ?bool
    {
        return $this->locked;
    }

    /**
     * @param bool|null $locked
     * @return WorkflowModel
     */
    public function setLocked(?bool $locked): WorkflowModel
    {
        $this->locked = $locked;
        return $this;
    }

    /**
     * @return AssigneeModel[]|null
     */
    public function getAssignees(): ?array
    {
        return $this->assignees;
    }

    /**
     * @param AssigneeModel[]|null $assignees
     * @return WorkflowModel
     */
    public function setAssignees(?array $assignees): WorkflowModel
    {
        $this->assignees = $assignees;
        return $this;
    }

    /**
     * @return VoucherModel|null
     */
    public function getVoucher(): ?VoucherModel
    {
        return $this->voucher;
    }

    /**
     * @param ?VoucherModel $voucher
     * @return WorkflowModel
     */
    public function setVoucher(?VoucherModel $voucher): WorkflowModel
    {
        $this->voucher = $voucher;
        return $this;
    }

    /**
     * @return StepModel|null
     */
    public function getStep(): ?StepModel
    {
        return $this->step;
    }

    /**
     * @param StepModel|null $step
     * @return WorkflowModel
     */
    public function setStep(?StepModel $step): WorkflowModel
    {
        $this->step = $step;
        return $this;
    }
}