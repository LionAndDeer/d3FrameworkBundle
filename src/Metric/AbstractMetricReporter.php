<?php

namespace Liondeer\Framework\Metric;

use Exception;
use Liondeer\Framework\Exception\LiondeerD3FrameworkException;
use Liondeer\Framework\IdentityProvider\IdentityProviderInterAppService;
use Liondeer\Framework\D3\Model\Metric;
use Liondeer\Framework\D3\Model\MetricReponse;
use Liondeer\Framework\D3\Model\Tenant;
use Psr\Cache\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

abstract class AbstractMetricReporter
{
    public function __construct(
        private IdentityProviderInterAppService $identityProviderInterAppService,
        private SerializerInterface $serializer,
        private LoggerInterface $logger
    )
    {
    }

    /**
     * @param Metric $metric
     * @param Tenant $tenant
     * @throws ClientExceptionInterface
     * @throws InvalidArgumentException
     * @throws LiondeerD3FrameworkException
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function sendMetricToDvelop(Metric $metric, Tenant $tenant)
    {
        $this->sendMetricsToDvelop([$metric], $tenant);
    }

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Liondeer\Exception\LiondeerD3FrameworkException
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Exception|\Psr\Cache\InvalidArgumentException
     */
    public function sendMetricsToDvelop(array $metrics, Tenant $tenant): LiondeerD3FrameworkException|Response
    {
        // hole sessionId
        try {
            $sessionId = $this->identityProviderInterAppService->getSessionId($tenant);
        } catch (Exception $e) {
            throw $e;
        }

        $usage = ['usage' => $metrics];
        $metricJson = $this->serializer->serialize($usage, "json");

        $baseUrl = $tenant->getBaseUri();

        $httpClient = HttpClient::create();
        try {
            //           $response = $httpClient->request(Request::METHOD_POST, $requestUrl . '/billing/metrics/usage', [
            $response = $httpClient->request(
                Request::METHOD_POST,
                $baseUrl . '/billing/metrics/usage',
                [
                    'headers' => [
                        'Content-Type' => 'application/json; charset=utf-8',
                        'Origin' => $baseUrl,
                        'Authorization' => 'Bearer ' . $sessionId,
                        'Accept' => 'application/json'
                    ],
                    'body' => $metricJson
                ]
            );

            /** @var MetricReponse $metricResponse */
            $metricResponse = $this->serializer->deserialize($response->getContent(), MetricReponse::class, 'json');

            if ($metricResponse->getRejected() != null) {
                $this->logger->info(
                    "Rejected Items: "
                    . $this->serializer->serialize($metricResponse->getRejected(), "json")
                );
                throw new LiondeerD3FrameworkException(
                    "Rejected Items: "
                    . $this->serializer->serialize($metricResponse->getRejected(), "json"), "LD-1004"
                );
            }

            return new Response('');
        } catch (TransportExceptionInterface $e) {
            $this->logger->error($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }
}