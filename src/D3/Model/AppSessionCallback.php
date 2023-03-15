<?php

namespace Liondeer\Framework\D3\Model;

class AppSessionCallback
{
    private string $sign;
    private string $authSessionId;
    private string $expire;

    public function getSign(): string
    {
        return $this->sign;
    }

    public function setSign(string $sign): void
    {
        $this->sign = $sign;
    }

    public function getAuthSessionId(): string
    {
        return $this->authSessionId;
    }

    public function setAuthSessionId(string $authSessionId): void
    {
        $this->authSessionId = $authSessionId;
    }

    public function getExpire(): string
    {
        return $this->expire;
    }

    public function setExpire(string $expire): void
    {
        $this->expire = $expire;
    }
}