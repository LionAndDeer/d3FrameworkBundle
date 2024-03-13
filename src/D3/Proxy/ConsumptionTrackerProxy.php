<?php

namespace Liondeer\Framework\D3\Proxy;

use Exception;
use Liondeer\Framework\D3\Model\ConsumptionTracker\RecordRequestModel;
use Liondeer\Framework\D3\Model\ConsumptionTracker\ReportRequestModel;
use Liondeer\Framework\D3\Proxy\IdentityProvider\InterAppProxy;
use Liondeer\Framework\Exception\LiondeerD3FrameworkException;
use Liondeer\Framework\Model\Tenant;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ConsumptionTrackerProxy
{

    private array $headers;
    public function __construct(
        private HttpClientInterface $client,
        private SerializerInterface $serializer,
        private InterAppProxy       $identityProviderInterAppService,
    )
    {

    }

    public function getAuthSessionId(Tenant $tenant)
    {
        try {
            return $this->identityProviderInterAppService->getSessionId($tenant);
        } catch (Exception $exception) {
            throw new LiondeerD3FrameworkException(
                'Die AuthSession für den Tenant '.$tenant->getTenantId().' konnte nicht geladen werden',
                404
            );
        }

    }
    private function setHeaders(string $authToken, ?string $acceptHeader = 'application/hal+json')
    {
        $this->headers = [
            'Authorization' => 'Bearer ' . $authToken,
            'Content-Type' => 'application/json'
        ];
    }


    public function sendRecord(Tenant $tenant, RecordRequestModel $recordModel)
    {

        $baseUrl = $tenant->getBaseUri();
        $authSessionId = $this->getAuthSessionId($tenant);
        $this->setHeaders($authSessionId);
        $response = $this->client->request(
            'POST',
            $baseUrl . '/consumptiontracker/api/v1/records',
            [
                'headers' => $this->headers,
                'body' => json_encode([
                    'Record' => [$recordModel],
                ])
            ]);

        if ($response->getStatusCode(false) === Response::HTTP_ACCEPTED) {
            return true;
        } else {
            throw new LiondeerD3FrameworkException(
                $response->getContent(false),
                $response->getStatusCode()
            );
        }

    }
    public function sendRecords(Tenant $tenant, $recordModelArray)
    {
        $baseUrl = $tenant->getBaseUri();
        $authSessionId = $this->getAuthSessionId($tenant);
        $this->setHeaders($authSessionId);
        $response = $this->client->request(
            'POST',
            $baseUrl . '/consumptiontracker/api/v1/records',
            [
                'headers' => $this->headers,
                'body' => json_encode([
                    'Record' => $recordModelArray,
                ])
            ]);

        if ($response->getStatusCode(false) === Response::HTTP_ACCEPTED) {
            return true;
        } else {
            throw new LiondeerD3FrameworkException(
                $response->getContent(false),
                $response->getStatusCode()
            );
        }
    }

    public function getReports(Tenant $tenant, ReportRequestModel $reportRequestModel)
    {
        $baseUrl = $tenant->getBaseUri();
        $authSessionId = $this->getAuthSessionId($tenant);
        $this->setHeaders($authSessionId);
        $response = $this->client->request(
            'GET',
            $baseUrl . '/consumptiontracker/api/v1/records',
            [
                'headers' => $this->headers,
                'query' => json_encode([
                     $reportRequestModel,
                ])
            ]);

        if ($response->getStatusCode(false) === Response::HTTP_ACCEPTED) {
            return true;
        } else {
            throw new LiondeerD3FrameworkException(
                $response->getContent(false),
                $response->getStatusCode()
            );
        }
    }
}