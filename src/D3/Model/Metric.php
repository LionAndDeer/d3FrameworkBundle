<?php

namespace Liondeer\Framework\D3\Model;

use DateTime;
use DateTimeInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;

class Metric
{
    /**
     * @SerializedName("metric")
     */
    private string $name;

    /**
     * @SerializedName("quantity")
     */
    private int $amount;

    /**
     * @SerializedName("timestamp")
     */
    private string $date;

    public function __construct()
    {
        $date = new DateTime('now');
        $this->date = $date->format(DateTimeInterface::ISO8601);
    }

    public function getName(): string
    {
        return $this->name;
    }


    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    public function getDate(): DateTime
    {
        return date_create_from_format(DateTimeInterface::ISO8601, $this->date);
    }

    public function setDate(DateTime $date = null): self
    {
        if (is_string($date)) {
            $this->date = $date;
        } else {
            $this->date = $date->format(DateTimeInterface::ISO8601);
        }
        return $this;
    }
}