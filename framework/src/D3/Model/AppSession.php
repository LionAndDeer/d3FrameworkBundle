<?php

namespace Liondeer\Framework\D3\Model;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class AppSession
{
    private string $appname;
    private string $callback;
    private string $requestId;

    /**
     * @throws \Exception
     */
    public function __construct(ParameterBagInterface $params)
    {
        $this->appname = $params->get("d3_app_name");
        $this->requestId = bin2hex(random_bytes(8));
    }

    public function getAppname(): string
    {
        return $this->appname;
    }

    public function setAppname(string $appname): void
    {
        $this->appname = $appname;
    }

    public function getCallback(): string
    {
        return $this->callback;
    }

    public function setCallback(string $callback): void
    {
        $this->callback = $callback;
    }

    public function getRequestId(): string
    {
        return $this->requestId;
    }

    public function setRequestId(string $requestId): void
    {
        $this->requestId = $requestId;
    }
}