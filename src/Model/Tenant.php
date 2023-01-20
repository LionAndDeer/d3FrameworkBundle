<?php


namespace Liondeer\Model;


use Symfony\Component\Serializer\Annotation\Groups;

class Tenant
{
    /**
     * @Groups("documentModel")
     */
    private string $tenantId;
    /**
     * @Groups("documentModel")
     */
    private string $baseUri;
    private bool $sharepointUser;

    public function isSharepointUser(): bool
    {
        return $this->sharepointUser;
    }

    public function setSharepointUser(bool $sharepointUser): Tenant
    {
        $this->sharepointUser = $sharepointUser;

        return $this;
    }

    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    public function setBaseUri(string $baseUri): Tenant
    {
        $this->baseUri = $baseUri;
        return $this;
    }

    public function getTenantId(): string
    {
        return $this->tenantId;
    }

    public function setTenantId(string $tenantId): Tenant
    {
        $this->tenantId = $tenantId;
        return $this;
    }
}