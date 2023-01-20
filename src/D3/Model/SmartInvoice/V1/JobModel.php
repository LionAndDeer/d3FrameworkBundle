<?php

namespace Liondeer\Framework\D3\Model\SmartInvoice\V1;

class JobModel
{
    public const STATUS_RUNNING = 'running';
    public const STATUS_SUCCESS = 'success';
    public const STATUS_FAILED = 'failed';
    public const STATUS_QUEUED = 'queued';

    private string $jobId;
    private string $status;
    private ?string $type = null;

    public function getJobId(): string
    {
        return $this->jobId;
    }

    public function setJobId(string $jobId): JobModel
    {
        $this->jobId = $jobId;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): JobModel
    {
        $this->status = $status;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): JobModel
    {
        $this->type = $type;

        return $this;
    }
}
