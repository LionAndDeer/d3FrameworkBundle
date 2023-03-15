<?php

namespace Liondeer\Framework\D3\Model\SmartInvoice\V1;

class SyncMetadataModel
{
    private string $tenantId;
    private string $baseUrl;
    private int $bucketId;
    private string $siApiKey;

    public function getTenantId(): string
    {
        return $this->tenantId;
    }

    public function setTenantId(string $tenantId): SyncMetadataModel
    {
        $this->tenantId = $tenantId;

        return $this;
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function setBaseUrl(string $baseUrl): SyncMetadataModel
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    public function getBucketId(): int
    {
        return $this->bucketId;
    }

    public function setBucketId(int $bucketId): SyncMetadataModel
    {
        $this->bucketId = $bucketId;

        return $this;
    }

    public function getSiApiKey(): string
    {
        return $this->siApiKey;
    }

    public function setSiApiKey(string $siApiKey): SyncMetadataModel
    {
        $this->siApiKey = $siApiKey;

        return $this;
    }
}
