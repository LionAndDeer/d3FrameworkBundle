<?php

namespace Liondeer\Framework\D3\Model\SmartInvoice\V1\Webhook;

class ConnectionModel
{
    private StepModel|null $fromStep = null;
    private StepModel|null $toStep = null;
    private string|null $end_mode = null;

    public const END_MODE_ABORTED = 'aborted';
    public const END_MODE_FINISHED = 'finished';

    /**
     * @return StepModel|null
     */
    public function getFromStep(): ?StepModel
    {
        return $this->fromStep;
    }

    /**
     * @param StepModel|null $fromStep
     * @return ConnectionModel
     */
    public function setFromStep(?StepModel $fromStep): ConnectionModel
    {
        $this->fromStep = $fromStep;
        return $this;
    }

    /**
     * @return StepModel|null
     */
    public function getToStep(): ?StepModel
    {
        return $this->toStep;
    }

    /**
     * @param StepModel|null $toStep
     * @return ConnectionModel
     */
    public function setToStep(?StepModel $toStep): ConnectionModel
    {
        $this->toStep = $toStep;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEndMode(): ?string
    {
        return $this->end_mode;
    }

    /**
     * @param string|null $end_mode
     * @return ConnectionModel
     */
    public function setEndMode(?string $end_mode): ConnectionModel
    {
        $this->end_mode = $end_mode;
        return $this;
    }
}